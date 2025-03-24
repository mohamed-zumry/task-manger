<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 projects
        $projects = Project::factory(5)->create();

        // Create 2 tasks for each project
        $projects->each(function ($project) {
            Task::factory(2)->create(['project_id' => $project->id]);
        });
    }
}
