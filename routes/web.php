<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\StudentController;

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
Route::middleware(['guest'])->group(function () {
    Route::get('/',[UserController::class,'index'])->name('login');
    Route::post('user_login',[UserController::class,'do_login']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('logout',[UserController::class,'user_logout']);
    Route::get('organisation-list',[OrganisationController::class,'index'])->name('organisationlist');
    Route::get('add-organisation/{org_type?}/{id?}',[OrganisationController::class,'create'])->name('addorganisation');
    Route::post('set-org-value/',[OrganisationController::class,'store']);
    Route::post('delete-org',[OrganisationController::class,'destroy']);
    Route::get('student-list',[StudentController::class,'index'])->name('studentlist');
    Route::get('student-edit/{id}',[StudentController::class,'create'])->name('studentedit');
    Route::post('set-std-value',[StudentController::class,'store']);
    Route::post('delete-student',[StudentController::class,'destroy']);
});

Route::get('register/{link}',[StudentController::class,'show']);
Route::post('do_register',[StudentController::class,'do_register']);
Route::get('error',function(){
    return view('error');
});
