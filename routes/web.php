<?php

use App\Http\Controllers\AdministrationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/dashboard')->controller(AdministrationController::class)->group(function () {
    Route::get('/', 'index')->name('administration.dashboard');
    Route::get('/schedule', 'scheduleMedic')->name('administration.schedule-medic');
    Route::get('/history', 'historyMedic')->name('administration.history-medic');
    Route::get('/patients', 'patients')->name('administration.patients');
    Route::get('/staff', 'staff')->name('administration.staff');
});
