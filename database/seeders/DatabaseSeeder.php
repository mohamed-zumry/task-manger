<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $projects = Project::factory(5)->create();

        $projects->each(function ($project) {
            // create 2 tasks for each project
            Task::factory(2)->create(['project_id' => $project->id]);
        });

    }
}
