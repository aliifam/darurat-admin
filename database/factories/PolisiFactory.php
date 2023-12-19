<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Polisi;

class PolisiFactory extends Factory
{
    protected $model = Polisi::class;

    public function definition()
    {
        // Rentang koordinat Jabodetabek, Sukabumi, dan Bandung
        $minLat = -6.9820; // Batas Selatan Jabodetabek dan Sukabumi
        $maxLat = -6.1918; // Batas Utara Sukabumi dan Bandung
        $minLong = 106.4944; // Batas Barat Jabodetabek
        $maxLong = 107.8221; // Batas Timur Bandung

        //rentang koordinat Kota Bandung dan kabupaten bandung
        $minLatBandung = -7.3128; // Batas Selatan Kota dan Kabupaten Bandung
        $maxLatBandung = -6.8283; // Batas Utara Kota dan Kabupaten Bandung
        $minLongBandung = 107.2984; // Batas Barat Kota dan Kabupaten Bandung
        $maxLongBandung = 107.934572; // Batas Timur Kota dan Kabupaten Bandung


        return [
            'nama' => 'Kepolisian ' . $this->faker->company,
            'alamat' => $this->faker->address,
            'telepon' => '628' . $this->faker->unique()->numerify('##########'),
            'wa' => '628' . $this->faker->unique()->numerify('##########'),
            'email' => $this->faker->email,
            'website' => $this->faker->url,
            'available' => $this->faker->boolean,
            'latitude' => round($this->random_float($minLatBandung, $maxLatBandung), 6),
            'longitude' => round($this->random_float($minLongBandung, $maxLongBandung), 6),
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
