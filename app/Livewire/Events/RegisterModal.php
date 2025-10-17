<?php

namespace App\Livewire\Events;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterModal extends Component
{
    use WithFileUploads;

    public bool $open = false;
    public int|string|null $eventId = null;
    public int $step = 1;

    // Step 1
    public $brand_name = '';
    public $mitra_address = '';
    public $type = '';
    public $owner_name = '';
    public $whatsapp = '';
    public $instagram = '';

    // Step 2
    public $product_photo;
    public $owner_ktp;
    public $business_permit_no = '';

    protected $listeners = ['openRegisterModal' => 'open'];

    #[On('openRegisterModal')]
    public function open($eventId)
    {
        $this->resetValidation();
        $this->resetExcept('open'); // ✅ cukup string, bukan array
        $this->open = true;
        $this->eventId = $eventId;
        $this->step = 1;
    }


    public function close()
    {
        $this->open = false;
    }

    public function next()
    {
        $this->validate([
            'brand_name'    => 'required|string|max:120',
            'mitra_address' => 'required|string|max:255',
            'type'          => 'required|string|max:60',
            'owner_name'    => 'required|string|max:120',
            'whatsapp'      => 'required|string|max:20',
            'instagram'     => 'nullable|string|max:80',
        ]);

        $this->step = 2;
    }

    public function back()
    {
        $this->step = 1;
    }

    public function submit()
    {
        $this->validate([
            'product_photo'     => 'required|image|max:2048',
            'owner_ktp'         => 'required|image|max:2048',
            'business_permit_no' => 'nullable|string|max:60',
        ]);

        // TODO: simpan ke DB sesuai modelmu.
        // Contoh minimal (pseudo):
        // $registration = EventRegistration::create([...]);
        // $registration->addMedia($this->product_photo->getRealPath())->toMediaCollection('product_photo');
        // $registration->addMedia($this->owner_ktp->getRealPath())->toMediaCollection('owner_ktp');

        $this->dispatch('toast', type: 'success', message: 'Pendaftaran berhasil dikirim.');
        $this->close();
    }

    public function render()
    {
        return view('livewire.events.register-modal');
    }
}
