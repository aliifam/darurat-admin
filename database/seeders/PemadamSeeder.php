<?php

namespace Database\Seeders;

use App\Models\Pemadam;
use Illuminate\Database\Seeder;

class PemadamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate 1000 faskes records for Pulau Jawa
        Pemadam::factory()->count(100)->create();
    }
}
