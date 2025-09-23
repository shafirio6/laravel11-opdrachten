<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create([
            'name' => 'Website Redesign',
            'description' => 'Herontwerp van de bedrijfswebsite met een modernere UI en betere performance.',
        ]);

        Project::create([
            'name' => 'Mobile App Development',
            'description' => 'Ontwikkeling van een mobiele app voor iOS en Android.',
        ]);

        Project::factory()->times(5)->hasTasks(2)->create();
    }
}
