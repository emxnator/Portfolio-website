<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;

Route::get('/', [HomeController::class , 'index'])->name('home');

Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
Route::get('/projects/{project}/delete', [ProjectController::class, 'delete'])->name('projects.delete');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
