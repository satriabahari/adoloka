<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EventRegistration extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'event_id',
        'umkm_brand_name',
        'partner_address',
        'business_type',
        'owner_name',
        'whatsapp_number',
        'instagram_name',
        'business_license_number',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('brand_photo')
            ->singleFile();

        $this->addMediaCollection('product_photo')
            ->singleFile();

        $this->addMediaCollection('ktp_photo')
            ->singleFile();
    }
}
