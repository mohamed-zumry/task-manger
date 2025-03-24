<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\TaskIndexController::class);
// Route::get('/', function () {
//    return view('index');
// });
