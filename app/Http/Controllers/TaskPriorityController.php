<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskPriorityRequest;
use App\Models\Task;
use App\Service\TaskService;
use Illuminate\Http\Request;

class TaskPriorityController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function updatePriority(TaskPriorityRequest $request, Task $task)
    {

;
        // Validate the incoming request
        $validated = $request->validated();

        // Update the task's priority
       // $task->priority = $validated['priority'];


        $updatedTask = $this->taskService->updateTaskPriority($task, $validated['priority']);

        // Early Exit if task update fail
        if (! $updatedTask) {
            return response()->json([
                'message' => 'Failed to update task priority.',
            ], 400);
        }

        // Return the updated task in the response
        return response()->json([
            'message' => 'Task priority updated successfully.',
            'task' => $updatedTask,
        ]);
    }
}
