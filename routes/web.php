<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CountryController;



Route::get('students', [StudentController::class, 'index']);

Route::get('students/list', [StudentController::class, 'getStudents'])->name('students.list');
Route::post('studnent/postdata', [StudentController::class, 'postData'])->name('student.postData');
Route::get('ajaxdata/fetchdata', [StudentController::class,'fetchdata'])->name('ajaxdata.fetchdata');
Route::get('ajaxdata/removedata', [StudentController::class,'removedata'])->name('ajaxdata.removedata');
Route::get('ajaxdata/massremove', [StudentController::class,'massremove'])->name('ajaxdata.massremove');

Route::get('/live_search', [CustomerController::class,'index']);
Route::get('/live_search/action', [CustomerController::class,'action'])->name('live_search.action');

Route::get('/autocomplete', [CountryController::class,'index']);
Route::post('/autocomplete/action', [CountryController::class,'action'])->name('autocomplete.action');
