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

        $todo = Activity::factory()->create(['id'=> 1,'name'=>'Todo']);
        $doing = Activity::factory()->create(['id'=> 2,'name'=>'Doing']);
        $testing = Activity::factory()->create(['id'=> 3,'name'=>'Testing']);
        $verify = Activity::factory()->create(['id'=> 4,'name'=>'Verify']);
        $done = Activity::factory()->create(['id'=> 5,'name'=>'Done']);

    }
}
