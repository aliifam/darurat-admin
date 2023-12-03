<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Faskes;

class FaskesFactory extends Factory
{
    protected $model = Faskes::class;

    public function definition()
    {
        $pulauJawaCoordinates = [
            'latitude' => -7.6145,
            'longitude' => 110.7126,
        ];

        $jenis = $this->faker->randomElement(['rumah_sakit', 'klinik', 'puskesmas']);
        $capitalizedJenis = ucwords(str_replace('_', ' ', $jenis));

        return [
            'nama' => $capitalizedJenis . ' ' . $this->faker->company,
            'alamat' => $this->faker->address,
            'telepon' => '628' . $this->faker->unique()->numerify('##########'),
            'wa' => '628' . $this->faker->unique()->numerify('##########'),
            'email' => $this->faker->email,
            'website' => $this->faker->url,
            'jenis' => $jenis,
            'bpjs' => $this->faker->boolean,
            'available' => $this->faker->boolean,
            'latitude' => $pulauJawaCoordinates['latitude'] + mt_rand() / mt_getrandmax() * 2,
            'longitude' => $pulauJawaCoordinates['longitude'] + mt_rand() / mt_getrandmax() * 2,
            'username' => $this->faker->userName,
            'password' => $this->faker->password,
        ];
    }
}
