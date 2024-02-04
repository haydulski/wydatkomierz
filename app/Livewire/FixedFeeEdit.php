<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Enums\FixedFeesTypes;
use App\Models\Category;
use App\Models\User;
use App\Models\FixedFee;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;

class FixedFeeEdit extends Component
{
    #[Locked]
    public User $user;

    public Collection $categories;

    public Collection $fees;

    public FixedFee $fee;

    public int $category_id;

    public float $amount;

    public string $title;

    public array $types;

    public int $type;


    public function mount(FixedFee $fee)
    {
        $this->user = auth()->user();
        $this->categories = Category::all();
        $this->types = FixedFeesTypes::cases();
        $this->fee = $fee;
        $this->type = $this->fee->type->value;
        $this->title = $this->fee->title;
        $this->amount = $this->fee->amount;
        $this->category_id = $this->fee->category->id;
    }

    public function render()
    {
        return view('livewire.fixed-fee-edit');
    }

    public function create()
    {
        $this->fee->updateOrFail(
            $this->only(['title', 'amount', 'category_id', 'type'])
        );

        return $this->redirectRoute('user.fees');
    }

    public function removeFee()
    {
        $this->fee->delete();

        return $this->redirectRoute('user.fees');
    }
}
