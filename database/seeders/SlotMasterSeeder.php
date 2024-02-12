<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SlotMaster;

class SlotMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startTime = strtotime('9:00');
        $endTime = strtotime('17:30');
        $currentTime = $startTime;

        while ($currentTime < $endTime) {
            $slotEndTime = $currentTime + (30 * 60); // Adding 30 minutes in seconds
            $insertArray[] = [
                'slot_timing' => date('H:ia', $currentTime) . ' - ' . date('H:ia', $slotEndTime) ,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $currentTime += 30 * 60; // Adding 30 minutes in seconds
        }

        SlotMaster::insert($insertArray);
    }
}
