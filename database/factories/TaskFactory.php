<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word, // Task Name
            'description' => $this->faker->sentence, // Task description
            'start_date' => Carbon::now()->addDays(rand(1, 30)), // Generate a future date
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']), // Task status
            'project_id' => Project::factory(), // Project belongs to the task
        ];
    }
}
