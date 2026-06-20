<?php
namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.guest')]
class Login extends Component {
    public $email = '';
    public $password = '';
    public $remember = false;

    public function login() {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $this->remember)) {
            session()->regenerate();
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->intended(route('home'));
        }

        $this->addError('email', 'Email atau password salah.');
    }

    public function render() {
        return view('livewire.auth.login');
    }
}