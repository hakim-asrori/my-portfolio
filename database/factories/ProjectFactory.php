<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'project_name' => fake()->name(),
            'project_domain' => fake()->url(),
            'project_status' => mt_rand(0, 1),
            'project_description' => fake()->text(500)
        ];
    }
}
