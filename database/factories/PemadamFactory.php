<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pemadam;

class PemadamFactory extends Factory
{
    protected $model = Pemadam::class;

    public function definition()
    {
        // Rentang koordinat Jabodetabek, Sukabumi, dan Bandung
        $minLat = -6.9820; // Batas Selatan Jabodetabek dan Sukabumi
        $maxLat = -6.1918; // Batas Utara Sukabumi dan Bandung
        $minLong = 106.4944; // Batas Barat Jabodetabek
        $maxLong = 107.8221; // Batas Timur Bandung


        return [
            'nama' => 'Pemadam Kebakaran ' . $this->faker->company,
            'alamat' => $this->faker->address,
            'telepon' => '628' . $this->faker->unique()->numerify('##########'),
            'wa' => '628' . $this->faker->unique()->numerify('##########'),
            'email' => $this->faker->email,
            'website' => $this->faker->url,
            'available' => $this->faker->boolean,
            'latitude' => round($this->random_float($minLat, $maxLat), 6),
            'longitude' => round($this->random_float($minLong, $maxLong), 6),
            'username' => $this->faker->userName,
            'password' => $this->faker->password,
        ];
    }

    // Fungsi untuk menghasilkan nilai float acak antara dua angka
    private function random_float($min, $max)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}
