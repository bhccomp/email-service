<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/',[App\Http\Controllers\ProjectsController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\ProjectsController::class, 'index'])->name('home');

Route::get('templates/list/{project_id}',[App\Http\Controllers\TemplatesController::class, 'index']);
Route::post('templates/create/{project_id}',[App\Http\Controllers\TemplatesController::class, 'store'])->name('templates.create');
Route::get('templates/new/{project_id}',[App\Http\Controllers\TemplatesController::class, 'create']);
Route::get('templates/edit/{template_id}',[App\Http\Controllers\TemplatesController::class, 'edit']);
Route::post('templates/edit/{template_id}',[App\Http\Controllers\TemplatesController::class, 'update'])->name('templates.edit');

Route::get('projects',[App\Http\Controllers\ProjectsController::class, 'index']);
Route::get('projects/new', [App\Http\Controllers\ProjectsController::class, 'store']);
Route::post('projects/edit/{id}', [App\Http\Controllers\ProjectsController::class, 'update']);
Route::get('projects/edit/{id}', [App\Http\Controllers\ProjectsController::class, 'edit'])->name('projects.edit');
Route::post('projects/create',[App\Http\Controllers\ProjectsController::class, 'store'])->name('projects.create');
Route::get('projects/overview/{id}', [App\Http\Controllers\ProjectsController::class, 'overview'])->name('projects.overview');

Route::get('emails/new', [App\Http\Controllers\UserEmailController::class, 'index']);
Route::post('emails/create', [App\Http\Controllers\UserEmailController::class, 'store'])->name('emails.create');

Route::view('/swagger','swagger');