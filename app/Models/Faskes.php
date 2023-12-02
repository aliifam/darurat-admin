<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Faskes extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    public static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'wa',
        'email',
        'website',
        'jenis',
        'bpjs',
        'available',
        'latitude',
        'longitude',
        'username',
        'password',
    ];

    // protected $hidden = [
    //     'password',
    // ];

    protected $appends = [
        'location'
    ];

    public function location(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return json_encode([
                    'lat' => (float) $attributes['latitude'],
                    'lng' => (float) $attributes['longitude'],
                ]);
            },
            set: function ($value) {
                return [
                    'latitude' => $value['lat'],
                    'longitude' => $value['lng'],
                ];
            }
        );
    }
}
