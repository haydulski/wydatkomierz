<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Category;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class CreateNote extends Component
{
    public Collection $categories;

    public string $title;

    public float $amount;

    public string $date;

    public string $info = '';

    public string $category_id = '1';

    public string $spent_at;

    public bool $is_common = false;

    #[Locked]
    public User $user;

    #[Locked]
    public int $user_id;

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->user_id = $this->user->id;
        $this->categories = Category::all();
    }

    public function create()
    {
        $this->spent_at = (new DateTime($this->date))->format('Y-m-d H:i:s');
        $this->user->expenses()->create(
            $this->only(['title', 'spent_at', 'amount', 'info', 'category_id', 'is_common'])
        );
        Cache::flush();

        return $this->redirectRoute('user.notes');
    }

    public function render(): View
    {
        $this->date = date('Y-m-d\TH:i', strtotime('now'));

        return view('livewire.add-note')->layoutData(['title' => 'Dodaj wydatek']);
    }
}
