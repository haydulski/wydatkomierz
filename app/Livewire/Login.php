<?php

namespace App\Livewire;

use Livewire\Component;

class Login extends Component
{
    public string $email = '';

    public string $password;

    public function login()
    {
        $validated = $this->validate([
            'email' => 'required|min:3|email',
            'password' => 'required|min:3',
        ]);
        if (auth()->attempt($validated)) {
            return $this->redirectRoute('home');
        }

        return redirect()->route('login')->with('error', 'Błędne hasło lub login');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
