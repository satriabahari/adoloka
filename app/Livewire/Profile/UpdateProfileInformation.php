<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class UpdateProfileInformation extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $phone = '';
    public $about = '';
    public $current_password = '';
    public $password = '';
    public $password_confirmation = '';

    /** @var TemporaryUploadedFile|null */
    public $avatar;

    public $show_password = false;
    public $show_current_password = false;
    public $show_password_confirmation = false;

    public $editing = [
        'name' => false,
        'email' => false,
        'phone' => false,
        'about' => false,
        'password' => false,
    ];

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Combine first_name and last_name for the name field
        $this->name = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
        $this->email = $user->email ?? '';
        $this->phone = $user->phone_number ?? '';
        $this->about = $user->about ?? '';
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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($field === 'password') {
            $this->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'Password saat ini tidak sesuai.');
                return;
            }

            $user->update(['password' => Hash::make($this->password)]);

            $this->current_password = '';
            $this->password = '';
            $this->password_confirmation = '';

            session()->flash('message', 'Password berhasil diperbarui!');
        } elseif ($field === 'name') {
            $this->validate([
                'name' => 'required|string|max:255',
            ]);

            // Split name into first_name and last_name
            $nameParts = explode(' ', $this->name, 2);
            $user->update([
                'first_name' => $nameParts[0] ?? '',
                'last_name' => $nameParts[1] ?? '',
            ]);

            session()->flash('message', 'Nama berhasil diperbarui!');
        } elseif ($field === 'phone') {
            $this->validate([
                'phone' => 'required|string|max:20',
            ]);

            $user->update(['phone_number' => $this->phone]);
            session()->flash('message', 'Nomor telepon berhasil diperbarui!');
        } else {
            $this->validate([
                $field => $field === 'email' ? 'required|email|unique:users,email,' . $user->id : 'required',
            ]);

            $user->update([$field => $this->$field]);
            session()->flash('message', ucfirst($field) . ' berhasil diperbarui!');
        }

        $this->editing[$field] = false;
    }

    public function uploadAvatar(): void
    {
        $this->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($this->avatar) {
            $user->clearMediaCollection('user');
            $user->addMedia($this->avatar->getRealPath())
                ->toMediaCollection('user');

            $this->reset('avatar');
            session()->flash('message', 'Avatar berhasil diupload!');
        }
    }

    private function resetField(string $field): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($field === 'password') {
            $this->current_password = '';
            $this->password = '';
            $this->password_confirmation = '';
        } elseif ($field === 'name') {
            $this->name = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
        } elseif ($field === 'phone') {
            $this->phone = $user->phone_number ?? '';
        } else {
            $this->$field = $user->$field ?? '';
        }
    }

    public function render()
    {
        return view('livewire.profile.update-profile-information');
    }
}
