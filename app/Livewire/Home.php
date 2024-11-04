<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class Home extends Component
{
    public User $user;

    public function mount(): void
    {
        $this->user = auth()->user();
    }

    public function logout()
    {
        auth()->logout();

        return $this->redirectRoute('login');
    }

    public function render(): View
    {
        return view('livewire.home')->layoutData(['title' => 'Wydatkomierz']);
    }
}
