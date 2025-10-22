<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Umkm extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'city',
        'latitude',
        'longitude',
        'address',
        'description',
        'halal_verified',
        'bpom_verified',
        'nib_verified',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'halal_verified' => 'boolean',
        'bpom_verified' => 'boolean',
        'nib_verified' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('halal_certificate')->singleFile();
        $this->addMediaCollection('bpom_certificate')->singleFile();
        $this->addMediaCollection('nib_certificate')->singleFile();
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
