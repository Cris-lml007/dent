<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\History;
use App\Models\Person;
use App\Models\Reservation;
use App\Models\StaffSchedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class AdministrationController extends Controller
{
    public function index(){
        if(Auth::user()->role == Role::PATIENT){
            return redirect()->route('home');
        }

        $heads = ['ID', 'Horario','Paciente', 'Medico', 'Especialidad'];
        if(Auth::user()->role == Role::MEDIC){
            $sessions = Reservation::whereHas('StaffSchedule',function(Builder $builder){
                $builder->where('user_id',Auth::user()->id);
            })->whereDate('date',Carbon::today())->whereDoesntHave('history')->count();

            $finish = Reservation::whereDate('date',Carbon::today())->whereHas('StaffSchedule',function(Builder $builder){
                $builder->where('user_id',Auth::user()->id);
            })->whereHas('history',function(Builder $builder){
                $builder->where('id','!=',null);
            })->count();

            $amount = History::whereHas('reservation',function(Builder $builder){
                $builder->whereHas('StaffSchedule',function(Builder $builder){
                    $builder->where('user_id',Auth::user()->id);
                })->whereDate('date',Carbon::today());
            })->sum('amount');
            $day = Carbon::now()->dayOfWeek;
            $free = StaffSchedule::where('day',$day)->where('user_id',Auth::user()->id)->count() - Reservation::whereHas('StaffSchedule',function(Builder $builder){
                $builder->where('user_id',Auth::user()->id);
            })->whereDate('date',Carbon::today())->count();
            $data = Reservation::whereHas('StaffSchedule',function(Builder $builder){
                $builder->where('user_id',Auth::user()->id);
            })->whereDate('date',Carbon::today())
              ->whereDoesntHave('history')->get();
        }else{
            $amount = History::whereHas('reservation',function(Builder $builder){
                $builder->whereDate('date',Carbon::today());
            })->sum('amount');
            $sessions = Reservation::whereDate('date','>=',Carbon::today())->count();
            $finish = Reservation::whereDate('date',Carbon::today())->whereHas('history',function(Builder $builder){
                $builder->where('id','!=',null);
            })->count();

            $day = Carbon::now()->dayOfWeek;
            $free = StaffSchedule::where('day',$day)->count() - Reservation::whereDate('date',Carbon::today())->count();
            $data = Reservation::whereDate('date',Carbon::today())->whereDoesntHave('history')->get();
        }
        // dd($data, Carbon::now());
        return view('administration.dashboard',compact(['heads', 'data', 'sessions', 'finish', 'amount','free']));
    }

    public function scheduleMedic() {
        $heads = ['ID', 'Fecha',' Horario', 'Paciente', 'Medico', ' Opciones'];
        if(Auth::user()?->role == Role::MEDIC){
            $is_medic = true;
            $data = Reservation::whereHas('StaffSchedule',function(Builder $builder){
                $builder->where('user_id',Auth::user()->id);
            })->whereDate('date','>=',Carbon::today())->orderBy('date','desc')->get();
        }else{
            $is_medic = false;
            $data = Reservation::orderBy('date','desc')->get();
        }
        return view('administration.schedule-medic',compact(['heads','data','is_medic']));
    }

    public function removeSchedule($id){
        Reservation::destroy($id);
        return redirect()->back();
    }

    public function historyMedic() {
        $heads = ['ID', ' Fecha','Horario', 'Paciente', 'Medico', 'Opciones'];
        $data = Reservation::whereHas('StaffSchedule',function(Builder $builder){
            $builder->where('user_id',Auth::user()->id);
        })->whereHas('history',function(Builder $builder){
            $builder->where('id','!=',null);
        })->orderBy('date','desc')->get();
        return view('administration.history-medic', compact(['heads', 'data']));
    }

    public function patients(){
        $heads = ['CI', 'Nombre', 'Edad', 'Telefono', 'Opciones'];
        $data = Person::all();
        return view('administration.patients', compact(['heads', 'data']));
    }

    public function staff(){
        // dd(User::all());
        $heads = ['CI', 'Nombre Completo', 'Rol', 'Telefono', 'Estado','Opciones'];
        $specialtyHeads = ['ID', 'Nombre', 'Opciones'];
        $data = Person::whereHas('users',function (Builder $query){
            $query->where('role','!=',Role::PATIENT);
        })->get();
        return view('administration.staff', compact(['heads','data','specialtyHeads']));
    }

    public function settings(){
        $headSpecialty = ['ID','Nombre', 'Descripción'];
        return view('administration.settings', compact(['headSpecialty']));
    }

    public function report(Request $request){
        $start = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end   = $request->end_date ?? now()->endOfMonth()->toDateString();

        // 🔹 KPI - Total ingresos
        $totalIncome = DB::table('histories')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        // 🔹 KPI - Total citas
        $totalReservations = DB::table('reservations')
            ->whereBetween('date', [$start, $end])
            ->count();

        // 🔹 KPI - Pacientes nuevos
        $newPatients = DB::table('people')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        // 🔹 Cancelaciones
        $cancelled = DB::table('reservations')
            ->whereBetween('date', [$start, $end])
            ->where('status', 'cancelled')
            ->count();

        $cancellationRate = $totalReservations > 0
            ? round(($cancelled / $totalReservations) * 100, 2)
            : 0;

        // 🔹 Ingresos por mes (para gráfico)
        $income = DB::table('histories')
            ->selectRaw("strftime('%m', created_at) as month")
            ->selectRaw("SUM(amount) as total")
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $incomeLabels = $income->pluck('month');
        $incomeValues = $income->pluck('total');


        $treatments = DB::table('history_treatments')
            ->join('people_treatments', 'history_treatments.people_treatment_id', '=', 'people_treatments.id')
            ->join('treatments', 'people_treatments.treatment_id', '=', 'treatments.id')
            ->select('treatments.name')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('treatments.name')
            ->orderByDesc('total')
            ->get();

        $treatmentLabels = $treatments->pluck('name');
        $treatmentValues = $treatments->pluck('total');

        $reservations = DB::table('reservations')
            ->select('date')
            ->selectRaw('COUNT(*) as total')
            ->whereDate('date', '>=', Carbon::today()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $reservationLabels = $reservations->pluck('date');
        $reservationValues = $reservations->pluck('total');

        return view('administration.report', compact(
            'start',
            'end',
            'totalIncome',
            'totalReservations',
            'newPatients',
            'cancellationRate',
            'incomeLabels',
            'treatmentLabels',
            'treatmentValues',
            'incomeValues',
            'reservationLabels',
            'reservationValues',
        ));
    }

    public function consultationPdf(History $history){
        $history->load([
            'patient',
            'reservation.StaffSchedule.staff',
            'treatments.treatment'
        ]);
        // dd(History::find(1)->patient);

        $pdf = Pdf::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ])->loadView('pdf.consultation',compact(['history']));
        $pdf->setPaper('letter');
        $pdf->render();
        return $pdf->stream();
    }

    public function historyPdf(Person $person){

        $totalPagado = $person->histories->sum('amount');
        $totalTratamientos = $person->histories->flatMap->treatments->sum('price');
        $totalPendiente = $totalTratamientos - $totalPagado;

        $pdf = Pdf::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ])->loadView('pdf.history',compact(['person','totalPagado','totalTratamientos','totalPendiente']));
        $pdf->setPaper('letter');
        $pdf->render();
        return $pdf->stream();
    }
}

