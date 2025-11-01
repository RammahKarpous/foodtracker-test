<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.guest')]
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function login()
    {
        $validated = $this->validate();
        
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $this->remember)) {
            request()->session()->regenerate();
            
            return redirect()->intended('/dashboard');
        }
        
        $this->addError('email', 'De ingevoerde gegevens zijn onjuist.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
