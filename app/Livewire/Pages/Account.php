<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Traits\WithToast;

#[Layout('layouts.app')]
class Account extends Component {
    use WithToast;

    public $activeTab = 'profile';
    
    // Profile Edit Properties
    public $editingProfile = false;
    public $profileForm = [
        'name' => '',
        'email' => '',
        'phone' => '',
    ];
    
    // Address Form Properties
    public $showAddressForm = false;
    public $editingAddressId = null;
    public $addressForm = [
        'label' => 'Rumah',
        'recipient_name' => '',
        'phone' => '',
        'full_address' => '',
        'city' => '',
        'postal_code' => '',
        'is_primary' => false,
    ];

    public function setTab($tab) {
        $this->activeTab = $tab;
    }
    
    public function editProfile() {
        $user = Auth::user();
        $this->profileForm = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '',
        ];
        $this->editingProfile = true;
    }
    
    public function saveProfile() {
        $this->validate([
            'profileForm.name' => 'required|string|max:255',
            'profileForm.email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'profileForm.phone' => 'nullable|string|max:20',
        ]);
        
        $user = Auth::user();
        $user->update([
            'name' => $this->profileForm['name'],
            'email' => $this->profileForm['email'],
            'phone' => $this->profileForm['phone'],
        ]);
        
        $this->editingProfile = false;
        $this->toast('Profile updated successfully!', 'success');
    }
    
    public function cancelEditProfile() {
        $this->editingProfile = false;
        $this->reset('profileForm');
    }

    public function createAddress() {
        $this->reset('addressForm', 'editingAddressId');
        $this->addressForm['is_primary'] = false;
        $this->addressForm['label'] = 'Rumah';
        $this->showAddressForm = true;
    }

    public function editAddress($id) {
        $addr = Auth::user()->addresses()->findOrFail($id);
        $this->editingAddressId = $addr->id;
        $this->addressForm = $addr->only(['label', 'recipient_name', 'phone', 'full_address', 'city', 'postal_code', 'is_primary']);
        $this->showAddressForm = true;
    }

    public function saveAddress() {
        $this->validate([
            'addressForm.label' => 'required|string',
            'addressForm.recipient_name' => 'required|string',
            'addressForm.phone' => 'required|string',
            'addressForm.full_address' => 'required|string',
            'addressForm.city' => 'required|string',
            'addressForm.postal_code' => 'required|string|max:10',
        ]);

        $user = Auth::user();
        
        // Tambahkan user_id ke data
        $addressData = array_merge($this->addressForm, ['user_id' => $user->id]);

        if ($this->addressForm['is_primary']) {
            $user->addresses()->update(['is_primary' => false]);
        }

        if ($this->editingAddressId) {
            $user->addresses()->findOrFail($this->editingAddressId)->update($addressData);
            $this->toast('Alamat berhasil diupdate', 'success');
        } else {
            $user->addresses()->create($addressData);
            $this->toast('Alamat berhasil ditambahkan', 'success');
        }

        $this->showAddressForm = false;
    }

    public function deleteAddress($id) {
        Auth::user()->addresses()->findOrFail($id)->delete();
        $this->toast('Alamat dihapus', 'info');
    }

    public function setDefaultAddress($id) {
        $user = Auth::user();
        $user->addresses()->update(['is_primary' => false]);
        $user->addresses()->findOrFail($id)->update(['is_primary' => true]);
        $this->toast('Alamat default diubah', 'success');
    }

    public function render() {
        $user = Auth::user()->fresh();
        $addresses = $user->addresses()->latest()->get();
        $orders = $user->orders()->latest()->get();
        
        return view('livewire.pages.account', [
            'user' => $user,
            'addresses' => $addresses,
            'orders' => $orders
        ]);
    }
}