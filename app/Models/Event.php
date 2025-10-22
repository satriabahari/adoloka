<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'start_date',
        'end_date',
        'type',
        'category',
        'is_strategic_location',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_strategic_location' => 'boolean',
    ];

    // === RELATIONSHIPS ===
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    // Gunakan slug untuk route model binding
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // === MEDIA LIBRARY ===
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('poster')
            ->useFallbackUrl(asset('images/placeholder.png'))
            ->singleFile();
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('poster') ?: asset('images/placeholder.png');
    }

    // === SCOPES ===
    public function scopeUpcoming($query)
    {
        return $query->whereDate('end_date', '>=', now()->toDateString())
            ->orderBy('start_date');
    }

    public function scopeOngoing($query)
    {
        $today = now()->toDateString();
        return $query->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today);
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // === ACCESSOR ===
    public function getDateRangeAttribute(): string
    {
        $start = $this->start_date;
        $end = $this->end_date;

        if (!$start || !$end) return '';

        return $start->isSameDay($end)
            ? $start->translatedFormat('d F Y')
            : $start->translatedFormat('d') . ' - ' . $end->translatedFormat('d F Y');
    }
}
