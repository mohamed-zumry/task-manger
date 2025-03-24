<?php

namespace App\Service;

use App\Models\Project;
use App\Models\Task;
use http\Exception\InvalidArgumentException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getTasksWithFilters(array $filters)
    {

        $tasks = Task::query();

        // Apply filters for project_id and status
        if (isset($filters['project_id'])) {
            $tasks = $tasks->projectId($filters['project_id']);
        }

        // sort by priority
     //   $tasks = $tasks->orderBy('priority', 'asc');


        //Eager load the project Relationship
        $tasks = $tasks->with('project:id,project_name');

        // Paginate the tasks
        return $tasks->paginate(10);
    }

    public function getAllProjects()
    {
        // only get selected fields
        return Project::select('id', 'project_name')->get();
    }

    public function updateTaskPriority(Task $task, int $priority)
    {
        try {
            DB::enableQueryLog();
            // Begin transaction
            // Begin transaction
            DB::beginTransaction();


            // Identify if the priority is being moved up or down
            // For moving the task from a higher priority (lower priority number) to a lower priority (higher priority number)

            // Moving a task from a higher priority to a lower priority (decreasing priority)
            if ($priority < $task->priority) {
                // Ensure priorities cannot go below 1
                Task::where('priority', '>=', $priority)
                    ->where('priority', '<', $task->priority)
                    ->where('priority', '>', 0)  // Prevent priority from going below 1
                    ->decrement('priority');
            } else {
                // Moving a task from a lower priority to a higher priority (increasing priority)
                Task::where('priority', '>', $task->priority)
                    ->where('priority', '<=', $priority)
                    ->increment('priority');
            }


            // Update the task's priority to the new value
            $task->priority = $priority;
            $task->save(); // Save the task with the new priority


            // Commit the transaction
            DB::commit();
            dd(DB::getQueryLog());
            return $task;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating task priority', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
