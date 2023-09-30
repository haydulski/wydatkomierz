<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Expense;
use App\Models\User;
use App\Models\Category;
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

    public function mount(Expense $expense)
    {
        $this->user = auth()->user();
        $this->note = $expense;
        $this->categories = Category::all();

        $this->title = $this->note->title;
        $this->info = $this->note->info;
        $this->amount = $this->note->amount;
        $this->category_id = $this->note->category_id;
    }

    public function change()
    {
        $this->note->updateOrFail(
            $this->only(['title', 'amount', 'info', 'category_id'])
        );
        Cache::flush();

        return $this->redirectRoute('user.notes');
    }

    public function render()
    {
        return view('livewire.edit-note');
    }
}
