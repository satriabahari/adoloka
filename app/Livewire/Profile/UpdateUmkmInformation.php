<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateUmkmInformation extends Component
{
    use WithFileUploads;

    public $nama_umkm;
    public $jenis_umkm;
    public $asal_produk;
    public $deskripsi;

    public $halal_certificate;
    public $bpom_certificate;
    public $nib_certificate;

    public $viewImage;
    public $showImageModal = false;

    public $editing = [
        'nama_umkm' => false,
        'jenis_umkm' => false,
        'asal_produk' => false,
        'deskripsi' => false,
    ];

    public function mount(): void
    {
        $umkm = Auth::user()->umkm;

        if ($umkm) {
            $this->nama_umkm = $umkm->business_name ?? '';
            $this->jenis_umkm = $umkm->business_type ?? '';
            $this->asal_produk = $umkm->city ?? '';
            $this->deskripsi = $umkm->description ?? '';
        }
    }

    public function toggle(string $field): void
    {
        $this->editing[$field] = !$this->editing[$field];

        if (!$this->editing[$field]) {
            $this->resetField($field);
        }
    }

    public function save(string $field): void
    {
        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            session()->flash('error', 'UMKM belum terdaftar.');
            return;
        }

        $fieldMap = [
            'nama_umkm' => 'business_name',
            'jenis_umkm' => 'business_type',
            'asal_produk' => 'city',
            'deskripsi' => 'description',
        ];

        $this->validate([
            $field => 'required',
        ]);

        $umkm->update([
            $fieldMap[$field] => $this->$field,
        ]);

        $this->editing[$field] = false;
        session()->flash('message', ucfirst(str_replace('_', ' ', $field)) . ' berhasil diperbarui!');
    }

    public function uploadCertificate(string $type): void
    {
        $this->validate([
            $type . '_certificate' => 'required|image|max:2048',
        ]);

        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            session()->flash('error', 'UMKM belum terdaftar.');
            return;
        }

        $collectionMap = [
            'halal' => 'halal_certificate',
            'bpom' => 'bpom_certificate',
            'nib' => 'nib_certificate',
        ];

        $collection = $collectionMap[$type];

        if ($this->{$type . '_certificate'}) {
            $umkm->clearMediaCollection($collection);
            $umkm->addMedia($this->{$type . '_certificate'}->getRealPath())
                ->toMediaCollection($collection);

            $this->reset($type . '_certificate');
            session()->flash('message', ucfirst($type) . ' certificate berhasil diupload!');
        }
    }

    public function viewCertificate(string $type): void
    {
        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            return;
        }

        $collectionMap = [
            'halal' => 'halal_certificate',
            'bpom' => 'bpom_certificate',
            'nib' => 'nib_certificate',
        ];

        $collection = $collectionMap[$type];
        $url = $umkm->getFirstMediaUrl($collection);

        if ($url) {
            $this->viewImage = $url;
            $this->showImageModal = true;
        }
    }

    public function closeModal(): void
    {
        $this->showImageModal = false;
        $this->viewImage = null;
    }

    private function resetField(string $field): void
    {
        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            return;
        }

        $fieldMap = [
            'nama_umkm' => 'business_name',
            'jenis_umkm' => 'business_type',
            'asal_produk' => 'city',
            'deskripsi' => 'description',
        ];

        $this->$field = $umkm->{$fieldMap[$field]} ?? '';
    }

    public function render()
    {
        return view('livewire.profile.update-umkm-information', [
            'umkm' => Auth::user()->umkm,
        ]);
    }
}
