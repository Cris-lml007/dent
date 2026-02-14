<?php

use App\Http\Controllers\AdministrationController;
use App\Livewire\AppointmentComponent;
use App\Livewire\PatientComponent;
use App\Livewire\SpecialtyComponent;
use App\Livewire\StaffComponent;
use App\Livewire\TreatmentComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/dashboard')->group(function(){
    Route::controller(AdministrationController::class)->group(function () {
        Route::get('/', 'index')->name('administration.dashboard');
        Route::get('/schedule', 'scheduleMedic')->name('administration.schedule-medic');
        Route::get('/schedule/{id}/delete', 'removeSchedule')->name('administration.schedule-medic.delete');
        Route::get('/history', 'historyMedic')->name('administration.history-medic');
        Route::get('/patients', 'patients')->name('administration.patients');
        Route::get('/staff', 'staff')->name('administration.staff');
        // Route::get('/settings', 'settings')->name('administration.settings');
        Route::get('/report', 'report')->name('administration.report');
        Route::get('/consultation/{history}', 'consultationPdf')->name('administration.consultationPdf');
        Route::get('/history/{person}', 'historyPdf')->name('administration.historyPdf');
    });

    Route::get('/staff/{person}', StaffComponent::class)->name('administration.staff.id');
    Route::get('/patients/{person}',PatientComponent::class)->name('administration.patients.id');
    Route::get('/schedule/{reservation}',AppointmentComponent::class)->name('administration.schedule-medic.id');
    Route::get('/treatments',TreatmentComponent::class)->name('administration.treatments');
    Route::get('/specialties',SpecialtyComponent::class)->name('administration.specialties');
});
