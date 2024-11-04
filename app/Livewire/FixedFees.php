<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;

class FixedFees extends Component
{
    #[Locked]
    public User $user;

    public Collection $fees;

    public function mount()
    {
        $this->user = User::with(['fees.category'])->find(auth()->user()->id);
        $this->fees = $this->user->fees;
    }

    public function render()
    {
        return view('livewire.fixed-fees')->layoutData(['title' => 'Stałe wydatki']);
    }
}
