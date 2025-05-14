<?php

namespace Database\Seeders;

use App\Models\RegularProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegularProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RegularProject::factory()->count(5)->create();
    }
}
