<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskIndexRequest;
use App\Service\TaskService;
use Illuminate\Http\Request;

class TaskIndexController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    // Display a listing of the tasks filtering by project or Status

    /**
     * @return void
     */
    public function __invoke(TaskIndexRequest $request)
    {

        // validate filters from the request
        $validatedRequest = $request->validated();

        // Get tasks with filters from the service
        $tasks = $this->taskService->getTasksWithFilters($validatedRequest);

        // Get all projects for the dropdown menu filter
        $projects = $this->taskService->getAllProjects();

        // dd( $tasks->items());

        return view('tasks.index', [
            'tasks' => $tasks->items(),  // Only the tasks data, not the paginator
            'projects' => $projects,
        ]);

    }
}
