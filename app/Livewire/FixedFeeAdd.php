<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Enums\FixedFeesTypes;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;

class FixedFeeAdd extends Component
{
    #[Locked]
    public User $user;

    public Collection $categories;

    public Collection $fees;

    public int $category_id;

    public float $amount;

    public string $title;

    public array $types;

    public int $type;

    public function mount()
    {
        $this->user = auth()->user();
        $this->categories = Category::all();
        $this->types = FixedFeesTypes::cases();
        $this->type = FixedFeesTypes::Daily->value;
    }

    public function render()
    {
        return view('livewire.fixed-fees-add');
    }

    public function create()
    {
        $this->user->fees()->create(
            $this->only(['title', 'amount', 'category_id', 'type'])
        );
        session()->flash('status', 'Wydatek dodany do listy!');

        return $this->redirectRoute('user.fees');
    }
}
