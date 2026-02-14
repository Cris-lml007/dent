<?php

namespace App\Livewire;

use App\Models\Treatment;
use Livewire\Component;

class TreatmentComponent extends Component
{
    public $name;
    public $description;
    public $treatment;
    public $price;
    public $search = '';

    public function updatedSearch(){
        $this->render();
    }

    public function getTreatment(Treatment $treatment){
        $this->treatment = $treatment;
        $this->name = $treatment->name;
        $this->description = $treatment->description;
        $this->price = $treatment->price;
    }

    public function clear(){
        $this->treatment = null;
        $this->name = null;
        $this->description = null;
        $this->price = null;
    }

    public function save(){
        if($this->treatment?->id == null)
            $this->treatment = new Treatment();

        $this->treatment->name = $this->name;
        $this->treatment->description = $this->description;
        $this->treatment->price = $this->price;
        $this->treatment->save();

        $this->treatment = null;
        $this->name = null;
        $this->description = null;
        $this->price = null;
    }

    public function render()
    {
        if($this->search != null || $this->search != ''){
            $treatments = Treatment::where('name','like','%'.$this->search.'%')
                ->orWhere('price','like','%'. $this->search .'%')
                ->orWhere('id','like','%'.$this->search.'%')
                ->get();
        }else{
            $treatments = Treatment::all();
        }
        return view('livewire.treatment-component',compact(['treatments']));
    }
}
