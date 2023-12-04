<?php

namespace Database\Seeders;

use App\Models\Polisi;
use Illuminate\Database\Seeder;

class PolisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate 1000 faskes records for Pulau Jawa
        Polisi::factory()->count(100)->create();
    }
}
