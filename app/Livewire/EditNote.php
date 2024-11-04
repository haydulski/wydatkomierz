<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Locked;
use Livewire\Component;

class EditNote extends Component
{
    public Collection $categories;

    public Expense $note;

    #[Locked]
    public User $user;

    public float $amount;

    public string $title;

    public string $info;

    public int $category_id;

    public bool $is_common;

    public function mount(Expense $expense)
    {
        $this->user = auth()->user();
        $this->note = $expense;
        $this->categories = Category::all();

        $this->title = $this->note->title;
        $this->info = $this->note->info;
        $this->amount = $this->note->amount;
        $this->category_id = $this->note->category_id;
        $this->is_common = (bool) $this->note->is_common;
    }

    public function change()
    {
        $this->note->updateOrFail(
            $this->only(['title', 'amount', 'info', 'category_id', 'is_common'])
        );
        Cache::flush();

        return $this->redirectRoute('user.notes');
    }

    public function render()
    {
        return view('livewire.edit-note');
    }
}
