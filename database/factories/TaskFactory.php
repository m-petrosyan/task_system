<?php

namespace Database\Factories;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
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
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(TaskStatusEnum::cases()),
            'due_date' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'user_id' => User::role('manager')->inRandomOrder()->first()->id,
            'assigned_user_id' => User::role('user')->inRandomOrder()->first()->id,
        ];
    }
}
