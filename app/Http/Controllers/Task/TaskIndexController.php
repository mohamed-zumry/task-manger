<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskIndexRequest;
use App\Service\Task\TaskService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class TaskIndexController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    // Display a listing of the tasks filtering by project or Status

    /**
     * @return Factory|View|Application|object
     */
    public function __invoke(TaskIndexRequest $request)
    {

        // validate filters from the request
        $validatedRequest = $request->validated();

        // Get Tasks with filters from the service
        $tasks = $this->taskService->getTasksWithFilters($validatedRequest);

        // Get all projects for the dropdown menu filter
        $projects = $this->taskService->getAllProjects();

        return view('tasks.index', [
            'tasks' => $tasks->items(),  // Only the tasks data, not the paginator
            'projects' => $projects,
        ]);

    }
}
