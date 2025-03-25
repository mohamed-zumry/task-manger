<?php

use App\Http\Controllers\Task\TaskIndexController;
use Illuminate\Support\Facades\Route;

//
Route::get('/', TaskIndexController::class);
