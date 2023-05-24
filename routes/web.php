<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DynamicFieldController;
use App\Http\Controllers\DynamicFormController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

//Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return view('auth.login');
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('dynamic-fields', DynamicFieldController::class);
Route::get('dynamic-forms/generatedForm/{dynamicForm}', [DynamicFormController::class, 'generatedForm'])->name('dynamic-forms.generatedForm');
Route::resource('dynamic-forms', DynamicFormController::class);