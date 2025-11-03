<?php

namespace App\Livewire\Profile;

use App\Models\EventAndUmkmCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateUmkmInformation extends Component
{
    use WithFileUploads;

    public $nama_umkm;
    public $category_id;    // id kategori terpilih
    public $kategori_nama;  // hanya tampilan
    public $asal_produk;
    public $deskripsi;

    public $categoryOptions = []; // [id => name]

    public $halal_certificate;
    public $bpom_certificate;
    public $nib_certificate;

    public $viewImage;
    public $showImageModal = false;

    public $editing = [
        'nama_umkm'   => false,
        'kategori'    => false,   // ganti dari 'jenis_umkm'
        'asal_produk' => false,
        'deskripsi'   => false,
    ];

    public function mount(): void
    {
        $umkm = Auth::user()->umkm; // hasOne

        // muat opsi kategori
        $this->categoryOptions = EventAndUmkmCategory::orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        if ($umkm) {
            $umkm->load('category');
            $this->nama_umkm    = $umkm->name ?? '';
            $this->category_id  = $umkm->category_id ?? null;
            $this->kategori_nama = optional($umkm->category)->name ?? '-';
            $this->asal_produk  = $umkm->city ?? '';
            $this->deskripsi    = $umkm->description ?? '';
        }
    }

    public function toggle(string $field): void
    {
        if ($field === 'jenis_umkm') $field = 'kategori';
        $this->editing[$field] = !$this->editing[$field];

        if (!$this->editing[$field]) {
            $this->resetField($field);
        }
    }

    public function save(string $field): void
    {
        if ($field === 'jenis_umkm') $field = 'kategori';

        $umkm = Auth::user()->umkm;
        if (!$umkm) {
            session()->flash('error', 'UMKM belum terdaftar.');
            return;
        }

        switch ($field) {
            case 'nama_umkm':
                $this->validate(['nama_umkm' => 'required|string|max:255']);
                $umkm->update(['name' => $this->nama_umkm]);
                break;

            case 'kategori':
                $this->validate(['category_id' => 'required|exists:event_and_umkm_categories,id']);
                $umkm->update(['category_id' => $this->category_id]);
                $umkm->load('category');
                $this->kategori_nama = optional($umkm->category)->name ?? '-';
                break;

            case 'asal_produk':
                $this->validate(['asal_produk' => 'required|string|max:255']);
                $umkm->update(['city' => $this->asal_produk]);
                break;

            case 'deskripsi':
                $this->validate(['deskripsi' => 'required|string']);
                $umkm->update(['description' => $this->deskripsi]);
                break;

            default:
                session()->flash('error', 'Field tidak dikenal.');
                return;
        }

        $this->editing[$field] = false;
        session()->flash('message', ucfirst(str_replace('_', ' ', $field)) . ' berhasil diperbarui!');
    }

    public function uploadCertificate(string $type): void
    {
        $this->validate([$type . '_certificate' => 'required|image|max:2048']);

        $umkm = Auth::user()->umkm;
        if (!$umkm) {
            session()->flash('error', 'UMKM belum terdaftar.');
            return;
        }

        $collectionMap = [
            'halal' => 'halal_certificate',
            'bpom'  => 'bpom_certificate',
            'nib'   => 'nib_certificate',
        ];
        $collection = $collectionMap[$type] ?? null;
        if (!$collection) return;

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
        if (!$umkm) return;

        $collectionMap = [
            'halal' => 'halal_certificate',
            'bpom'  => 'bpom_certificate',
            'nib'   => 'nib_certificate',
        ];
        $collection = $collectionMap[$type] ?? null;
        if (!$collection) return;

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
        if ($field === 'jenis_umkm') $field = 'kategori';

        $umkm = Auth::user()->umkm;
        if (!$umkm) return;

        $umkm->load('category');

        switch ($field) {
            case 'nama_umkm':
                $this->nama_umkm = $umkm->name ?? '';
                break;
            case 'kategori':
                $this->category_id   = $umkm->category_id ?? null;
                $this->kategori_nama = optional($umkm->category)->name ?? '-';
                break;
            case 'asal_produk':
                $this->asal_produk = $umkm->city ?? '';
                break;
            case 'deskripsi':
                $this->deskripsi = $umkm->description ?? '';
                break;
        }
    }

    public function render()
    {
        return view('livewire.profile.update-umkm-information', [
            'umkm' => Auth::user()->umkm,
        ]);
    }
}
