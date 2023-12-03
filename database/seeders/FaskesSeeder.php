<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faskes;

class FaskesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate 1000 faskes records for Pulau Jawa
        Faskes::factory()->count(100)->create();
    }
}
