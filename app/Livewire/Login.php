<?php

namespace App\Livewire;

use Livewire\Component;

class Login extends Component
{
    public string $user = '';

    public string $password;

    public function login()
    {
        if (config('app.user') === $this->user && config('app.password') === $this->password) {
            session()->put('current-user', $this->user);
            return $this->redirectRoute('home');
        } else {
            return redirect()->route('login')->with('error', 'Błędne hasło lub login');
        }
    }

    public function render()
    {
        return view('livewire.login');
    }
}
