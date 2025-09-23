<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
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
//        $this->faker->addProvider(new \Faker\Provider\FakeCar($this->faker));
        return [
            'task' => $this->faker->realText($this->faker->numberBetween(10,200)),
            'user_id' =>User::all()->random()->id,
            'activity_id' => Activity::all()->random()->id,
            'project_id' => Project::all()->random()->id,
            'begindate' => Carbon::Today(),
            'enddate' => Carbon::Today()->addDays(10),
        ];
    }
}
