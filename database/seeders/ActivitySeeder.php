<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            ['id' => 1, 'name' => 'Todo'],
            ['id' => 2, 'name' => 'Doing'],
            ['id' => 3, 'name' => 'Testing'],
            ['id' => 4, 'name' => 'Verify'],
            ['id' => 5, 'name' => 'Done'],
        ];

        Activity::insert($activities);
    }
}
