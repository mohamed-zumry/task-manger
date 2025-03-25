<?php

namespace App\Service\Task;

use App\Models\Project;
use App\Models\Task;
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

        // Sort by priority
        $tasks = $tasks->orderBy('priority', 'asc');

        // Eager load the project Relationship
        $tasks = $tasks->with('project:id,project_name');

        // paginate the tasks
        return $tasks->paginate(10);
    }

    // Get all project to load to dropdown
    public function getAllProjects()
    {
        // only get selected fields
        return Project::select('id', 'project_name')->get();
    }

    // Update task priority
    public function updateTaskPriority(Task $task, int $priority)
    {
        try {

            DB::beginTransaction();

            $oldPriority = $task->priority;
            if ($oldPriority == $priority) {
                return true;
            }

            if ($priority < $oldPriority) {
                // Drag task up: Shift priorities down for tasks between new and old position
                Task::whereBetween('priority', [$priority, $oldPriority - 1])
                    ->increment('priority');
            } else {
                // Drag task down: Shift priorities up for tasks between old and new position
                Task::whereBetween('priority', [$oldPriority + 1, $priority])
                    ->decrement('priority');
            }

            // Update the tasks priority to the new value
            $task->priority = $priority;
            $task->save();

            //Commit the transaction
            DB::commit();

            return $task;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating task priority', ['error' => $e->getMessage()]);

            return false;
        }
    }
}
