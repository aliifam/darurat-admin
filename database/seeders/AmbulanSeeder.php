<?php

namespace Database\Seeders;

use App\Models\Ambulan;
use Illuminate\Database\Seeder;

class AmbulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate 1000 faskes records for Pulau Jawa
        Ambulan::factory()->count(50)->create();
    }
}
