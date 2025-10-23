<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'umkm_id',
        'category_id',
        'name',
        'description',
        'slug',
        'price',
        'unit',
        'consultation_link',
        'has_brand_identity',
        'revision_max',
        'delivery_days_min',
        'delivery_days_max',
        'is_active',
    ];

    protected $casts = [
        'has_brand_identity' => 'bool',
        'is_active' => 'bool',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            static::ensureSlug($service);
        });

        static::updating(function (Service $service) {
            if ($service->isDirty('name') && empty($service->slug)) {
                static::ensureSlug($service);
            }
        });
    }

    protected static function ensureSlug(Service $service): void
    {
        if (!empty($service->slug)) {
            return;
        }

        $base = Str::slug($service->name);
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)
            ->when($service->exists, fn($q) => $q->where('id', '!=', $service->id))
            ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        $service->slug = $slug;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('service')
            ->useFallbackUrl(asset('images/placeholder.png'))
            ->singleFile();
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('service') ?: asset('images/placeholder.png');
    }

    // === RELATIONS ===
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    // Helper untuk UI (opsional tapi berguna)
    public function getDeliveryLabelAttribute(): ?string
    {
        $min = $this->delivery_days_min;
        $max = $this->delivery_days_max ?? $min;

        if (is_null($min) && is_null($max)) return null;
        return $min === $max ? "{$min} hari" : "{$min}-{$max} hari";
    }

    public function getRevisionLabelAttribute(): string
    {
        return $this->revision_max > 0
            ? "Maks {$this->revision_max}x revisi"
            : "Tanpa revisi";
    }
}
