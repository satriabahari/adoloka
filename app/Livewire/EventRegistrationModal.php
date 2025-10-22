<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\EventRegistration;

class EventRegistrationModal extends Component
{
    use WithFileUploads;

    public $event;
    public $showModal = false;

    // Form fields
    public $umkm_brand_name;
    public $partner_address;
    public $business_type;
    public $owner_name;
    public $whatsapp_number;
    public $instagram_name;
    public $brand_photo;
    public $product_photo;
    public $ktp_photo;
    public $business_license_number;

    protected $rules = [
        'umkm_brand_name' => 'required|string|max:255',
        'partner_address' => 'required|string',
        'business_type' => 'required|string|max:255',
        'owner_name' => 'required|string|max:255',
        'whatsapp_number' => 'required|string|max:20',
        'instagram_name' => 'nullable|string|max:255',
        'brand_photo' => 'required|image|max:2048',
        'product_photo' => 'required|image|max:2048',
        'ktp_photo' => 'required|image|max:2048',
        'business_license_number' => 'nullable|string|max:255',
    ];

    public function mount($event)
    {
        $this->event = $event;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset([
            'umkm_brand_name',
            'partner_address',
            'business_type',
            'owner_name',
            'whatsapp_number',
            'instagram_name',
            'brand_photo',
            'product_photo',
            'ktp_photo',
            'business_license_number'
        ]);
        $this->resetValidation();
    }

    public function submit()
    {
        $this->validate();

        $registration = EventRegistration::create([
            'event_id' => $this->event->id,
            'umkm_brand_name' => $this->umkm_brand_name,
            'partner_address' => $this->partner_address,
            'business_type' => $this->business_type,
            'owner_name' => $this->owner_name,
            'whatsapp_number' => $this->whatsapp_number,
            'instagram_name' => $this->instagram_name,
            'business_license_number' => $this->business_license_number,
        ]);

        // Upload photos using Spatie Media Library
        if ($this->brand_photo) {
            $registration->addMedia($this->brand_photo->getRealPath())
                ->usingFileName($this->brand_photo->getClientOriginalName())
                ->toMediaCollection('brand_photo');
        }

        if ($this->product_photo) {
            $registration->addMedia($this->product_photo->getRealPath())
                ->usingFileName($this->product_photo->getClientOriginalName())
                ->toMediaCollection('product_photo');
        }

        if ($this->ktp_photo) {
            $registration->addMedia($this->ktp_photo->getRealPath())
                ->usingFileName($this->ktp_photo->getClientOriginalName())
                ->toMediaCollection('ktp_photo');
        }

        session()->flash('success', 'Pendaftaran berhasil! Kami akan menghubungi Anda segera.');

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.event-registration-modal');
    }
}
