<?php

use App\Http\Controllers\TaskPriorityController;
use Illuminate\Support\Facades\Route;

Route::patch('/tasks/{task}/update-priority', [TaskPriorityController::class, 'updatePriority']);
