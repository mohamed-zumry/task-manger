<?php


use App\Http\Controllers\Task\TaskPriorityController;
use Illuminate\Support\Facades\Route;

// Api call for Update Task Priority
Route::patch('/tasks/{task}/update-priority', [TaskPriorityController::class, 'updatePriority']);
