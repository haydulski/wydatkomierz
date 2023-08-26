<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Home extends Component
{
    public Collection $users;

    public function mount(): void
    {
        $this->users = User::toBase()->select(['id', 'first_name'])->get();
    }

    public function showUser(int $id)
    {
        if (User::find($id)->exists()) {
            return redirect()->route('user.notes', ['user' => $id]);;
        }
    }

    public function logout()
    {
        session()->flush();

        return $this->redirectRoute('login');
    }

    public function render(): View
    {
        return view('livewire.home');
    }
}
