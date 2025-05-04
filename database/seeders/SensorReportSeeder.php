<?php

namespace Database\Seeders;
use App\Models\SensorReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SensorReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SensorReport::factory()->count(2)->create();
    }
}
