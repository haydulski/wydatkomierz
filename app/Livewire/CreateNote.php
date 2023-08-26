<?php

declare(strict_types=1);

namespace App\Livewire;

use DateTime;
use Livewire\Component;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Attributes\Locked;

class CreateNote extends Component
{
    public Collection $categories;

    public string $title;

    public float $amount;

    public string $date;

    public string $info = '';

    public string $category_id = '1';

    public string $spent_at;

    #[Locked]
    public User $user;

    #[Locked]
    public int $user_id;

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->user_id = $user->id;
        $this->categories = Category::all();
    }

    public function create()
    {
        $this->spent_at = (new DateTime($this->date))->format('Y-m-d H:i:s');
        $this->user->expenses()->create(
            $this->only(['title', 'spent_at', 'amount', 'info', 'category_id'])
        );

        Cache::flush();

        return $this->redirect("/lista/$this->user_id");
    }

    public function render(): View
    {
        return view('livewire.add-note');
    }
}
