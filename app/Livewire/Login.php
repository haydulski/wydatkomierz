<?php

namespace App\Livewire;

use Livewire\Component;

class Login extends Component
{
    public string $user = '';

    public string $password;

    public function login()
    {
        $creds = ['email' => $this->user, 'password' => $this->password];
        if (auth()->attempt($creds)) {
            return $this->redirectRoute('home');
        }

        return redirect()->route('login')->with('error', 'Błędne hasło lub login');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
