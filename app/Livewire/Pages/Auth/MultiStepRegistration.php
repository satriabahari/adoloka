<?php

namespace App\Livewire\Pages\Auth;

use App\Models\Product;
use App\Models\Umkm;
use App\Models\User;
use App\Models\Category;
use App\Models\EventAndUmkmCategory;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class MultiStepRegistration extends Component
{
    use WithFileUploads;

    // Step tracker
    public $currentStep = 1;
    public $totalSteps = 3;

    // Step 1: User data
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone_number = '';
    public $password = '';
    public $password_confirmation = '';
    public $agree_terms = false;

    // Step 2: UMKM data
    public $business_name = '';
    public $umkm_category_id = '';
    public $city = '';
    public $latitude;
    public $longitude;
    public $address = '';
    public $business_description = '';
    public $umkmCategories = [];

    // Step 3: Product data
    public $product_name = '';
    public $product_category_id = '';
    public $product_photo;
    public $product_description = '';
    public $productCategories = [];

    // Track if user came from Google
    public $fromGoogle = false;

    protected $messages = [
        'first_name.required' => 'Nama depan wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',
        'phone_number.required' => 'Nomor telepon wajib diisi',
        'phone_number.regex' => 'Nomor telepon harus angka dan diawali +62 atau 08 (contoh: +628123456789 atau 08123456789)',
        'phone_number.unique' => 'Nomor telepon sudah terdaftar',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
        'agree_terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        'business_name.required' => 'Nama usaha wajib diisi',
        'umkm_category_id.required' => 'Kategori usaha wajib dipilih',
        'umkm_category_id.exists' => 'Kategori usaha tidak valid',
        'city.required' => 'Kota wajib diisi',
        'latitude.required' => 'Lokasi usaha wajib dipilih pada peta',
        'longitude.required' => 'Lokasi usaha wajib dipilih pada peta',
        'product_name.required' => 'Nama produk wajib diisi',
        'product_photo.image' => 'File harus berupa gambar',
        'product_photo.max' => 'Ukuran gambar maksimal 2MB',
        'product_category_id.required' => 'Kategori produk wajib dipilih',
        'product_category_id.exists' => 'Kategori produk tidak valid',
    ];

    public function mount()
    {
        // Load categories dulu (diperlukan di semua step)
        $this->productCategories = ProductCategory::select('id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();

        $this->umkmCategories = EventAndUmkmCategory::select('id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();

        // Check if there's a step parameter in the URL
        $requestedStep = request()->query('step');
        $requestedStep = $requestedStep ? (int) $requestedStep : null;

        // Check if user is authenticated (from Google OAuth or already logged in)
        if (Auth::check()) {
            $user = Auth::user();

            // Load user data
            $this->first_name = $user->first_name ?? '';
            $this->last_name = $user->last_name ?? '';
            $this->email = $user->email ?? '';
            $this->phone_number = $user->phone_number ?? '';

            // Set flag if user has google_id (came from Google)
            if ($user->google_id) {
                $this->fromGoogle = true;

                // User dari Google langsung mark step 1 completed
                session(['registration_step_1_completed' => true]);
            }

            // Set step based on URL parameter OR user status
            if ($requestedStep && in_array($requestedStep, [1, 2, 3], true)) {
                // Validasi: user hanya bisa akses step yang sudah unlocked
                $allowedStep = $this->getMaxAllowedStep();

                if ($requestedStep <= $allowedStep) {
                    $this->currentStep = $requestedStep;
                } else {
                    // Redirect ke step terakhir yang valid
                    $this->currentStep = $allowedStep;
                    return redirect()->to('/register?step=' . $allowedStep);
                }
            } elseif (!$user->umkm) {
                // If no step specified but user doesn't have UMKM, go to step 2
                $this->currentStep = 2;
            } else {
                // User already has UMKM, shouldn't be here
                return redirect()->route('home');
            }
        } else {
            // Not authenticated
            if ($requestedStep && in_array($requestedStep, [1, 2, 3], true)) {
                // Validasi: hanya bisa akses step yang sudah completed
                $allowedStep = $this->getMaxAllowedStep();

                if ($requestedStep <= $allowedStep) {
                    $this->currentStep = $requestedStep;
                } else {
                    // Redirect ke step terakhir yang valid
                    $this->currentStep = $allowedStep;
                    return redirect()->to('/register?step=' . $allowedStep);
                }
            } else {
                // Default: new registration, start at step 1
                $this->currentStep = 1;
            }
        }

        // Load data dari session jika ada (untuk maintain data saat refresh)
        $this->loadFromSession();
    }

    /**
     * Get maximum allowed step based on completed steps
     */
    private function getMaxAllowedStep(): int
    {
        // Jika user authenticated via Google, langsung unlock step 2
        if (Auth::check() && Auth::user()->google_id) {
            return session('registration_step_2_completed') ? 3 : 2;
        }

        // Check session untuk step yang sudah completed
        if (session('registration_step_2_completed')) {
            return 3; // Bisa akses step 3
        }

        if (session('registration_step_1_completed')) {
            return 2; // Bisa akses step 2
        }

        return 1; // Hanya bisa akses step 1
    }

    /**
     * Save current step data to session
     */
    private function saveToSession()
    {
        if ($this->currentStep == 1) {
            session([
                'registration_step_1_data' => [
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'email' => $this->email,
                    'phone_number' => $this->phone_number,
                ]
            ]);
        } elseif ($this->currentStep == 2) {
            session([
                'registration_step_2_data' => [
                    'business_name' => $this->business_name,
                    'umkm_category_id' => $this->umkm_category_id,
                    'city' => $this->city,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'address' => $this->address,
                    'business_description' => $this->business_description,
                ]
            ]);
        }
    }

    /**
     * Load data from session
     */
    private function loadFromSession()
    {
        // Load step 1 data
        if ($step1Data = session('registration_step_1_data')) {
            $this->first_name = $step1Data['first_name'] ?? $this->first_name;
            $this->last_name = $step1Data['last_name'] ?? $this->last_name;
            $this->email = $step1Data['email'] ?? $this->email;
            $this->phone_number = $step1Data['phone_number'] ?? $this->phone_number;
        }

        // Load step 2 data
        if ($step2Data = session('registration_step_2_data')) {
            $this->business_name = $step2Data['business_name'] ?? $this->business_name;
            $this->umkm_category_id = $step2Data['umkm_category_id'] ?? $this->umkm_category_id;
            $this->city = $step2Data['city'] ?? $this->city;
            $this->latitude = $step2Data['latitude'] ?? $this->latitude;
            $this->longitude = $step2Data['longitude'] ?? $this->longitude;
            $this->address = $step2Data['address'] ?? $this->address;
            $this->business_description = $step2Data['business_description'] ?? $this->business_description;
        }
    }

    // Step 1 validation rules
    protected function step1Rules()
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone_number' => [
                'required',
                'string',
                'max:20',
                'regex:/^(\+62|0)8[0-9]{7,12}$/'
            ],
            'agree_terms' => 'accepted',
        ];

        // Jika user dari Google (sudah punya email)
        if ($this->fromGoogle && Auth::check()) {
            $userId = Auth::id();
            $rules['email'] = [
                'required',
                'email',
                'unique:users,email,' . $userId
            ];
        } else {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }

    // Step 2 validation rules
    protected function step2Rules()
    {
        return [
            'business_name' => 'required|string|max:255',
            'umkm_category_id' => 'required|exists:event_and_umkm_categories,id',
            'city' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'address' => 'nullable|string|max:500',
            'business_description' => 'nullable|string|max:1000',
        ];
    }

    // Step 3 validation rules
    protected function step3Rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'product_category_id' => 'required|integer|exists:product_categories,id',
            'product_photo' => 'nullable|image|max:2048',
            'product_description' => 'nullable|string|max:1000',
        ];
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate($this->step1Rules());

            // Mark step 1 as completed
            session(['registration_step_1_completed' => true]);

            // Save data to session
            $this->saveToSession();
        } elseif ($this->currentStep == 2) {
            $this->validate($this->step2Rules());

            // Mark step 2 as completed
            session(['registration_step_2_completed' => true]);

            // Save data to session
            $this->saveToSession();
        }

        $this->currentStep++;

        // Update URL
        $this->dispatch('updateUrl', step: $this->currentStep);
    }

    public function previousStep()
    {
        $this->currentStep--;

        // Update URL
        $this->dispatch('updateUrl', step: $this->currentStep);

        // Dispatch event to browser to reinitialize map when going back to step 2
        if ($this->currentStep == 2) {
            $this->js('window.dispatchEvent(new Event("reinit-map"))');
        }
    }

    public function setLocation($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function submit()
    {
        // Validate step 3
        $this->validate($this->step3Rules());

        $user = null;

        // Check if user already authenticated (from Google)
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Update phone number if provided
            if ($this->phone_number) {
                $user->update([
                    'phone_number' => $this->phone_number,
                ]);
            }
        } else {
            // Create new user (regular registration)
            $last = trim((string) $this->last_name);
            $user = User::create([
                'first_name' => $this->first_name,
                'last_name' => $last === '' ? null : $last,
                'role_id' => 2,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'password' => Hash::make($this->password),
            ]);

            // Log in the user
            Auth::login($user);
        }

        // Create UMKM with address field
        $umkm = Umkm::create([
            'user_id' => $user->id,
            'name' => $this->business_name,
            'category_id' => $this->umkm_category_id,
            'city' => $this->city,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address,
            'description' => $this->business_description,
        ]);

        // Create Product
        $product = Product::create([
            'umkm_id' => $umkm->id,
            'user_id' => $user->id,
            'name' => $this->product_name,
            'description' => $this->product_description,
            'category_id' => $this->product_category_id,
        ]);

        // Upload product photo using Spatie Media Library
        if ($this->product_photo) {
            try {
                $product->addMedia($this->product_photo->getRealPath())
                    ->usingFileName($this->product_photo->getClientOriginalName())
                    ->toMediaCollection('product');
            } catch (\Exception $e) {
                Log::error('Failed to upload product photo: ' . $e->getMessage());
            }
        }

        // Clear registration session data
        session()->forget([
            'registration_step_1_completed',
            'registration_step_2_completed',
            'registration_step_1_data',
            'registration_step_2_data',
        ]);

        // Redirect to dashboard with success message
        session()->flash('success', 'Registrasi berhasil! Selamat datang di platform UMKM.');

        return redirect()->route('home');
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.pages.auth.multi-step-registration');
    }
}
