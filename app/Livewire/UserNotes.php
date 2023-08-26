<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Expense;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class UserNotes extends Component
{

    private const DB_DATE_FORMAT = 'Y-m-d H:i:s';

    private CarbonImmutable $dateFrom;

    private CarbonImmutable $dateTo;

    public User $user;

    public $expenses;

    public string $currentYear;

    public string $previousYear;

    public function mount(User $user, ?string $year = null)
    {
        $this->user = $user;

        if ($year === null || $year === CarbonImmutable::now()->format('Y')) {
            $this->dateFrom = CarbonImmutable::now()->startOfYear();
            $this->dateTo = CarbonImmutable::now();
        } else {
            $this->dateFrom = CarbonImmutable::create($year)->startOfYear();
            $this->dateTo = CarbonImmutable::create($year)->endOfYear();
        }

        $this->currentYear = $this->dateTo->format('Y');
        $this->previousYear = $this->dateTo->subYear()->format('Y');

        $this->expenses = Cache::remember(
            "$this->currentYear-expenses",
            3600,
            fn () => $this->getFormatedExpenses($this->dateFrom, $this->dateTo)
        );
    }

    public function prevYear(string $year): void
    {
        if ($year !== 'now') {
            $this->mount($this->user, $year);
        } else {
            $this->mount($this->user, null);
        }
    }

    public function groupBy(string $type)
    {
        $sortedArray = [];

        foreach ($this->expenses as $key => $subCollection) {
            $sortedArray[$key] = $subCollection->sortByDesc($type);
        }
        $this->expenses = $sortedArray;
    }

    public function delete(int $id, int $userId, string $year)
    {
        $user = User::find($userId);
        $note = Expense::find($id);
        $note->delete();
        Cache::flush();

        $this->mount($user, $year);
    }

    public function render()
    {
        return view('livewire.user-notes');
    }

    private function getFormatedExpenses(CarbonImmutable $dateFrom, CarbonImmutable $dateTo)
    {
        $expensesRaw = $this->user->expenses()->with('category:name,id')
            ->latest('spent_at')
            ->whereBetween('spent_at', [$dateFrom, $dateTo])
            ->get();

        return $expensesRaw->groupBy(function ($item) {
            // Parse the 'date' attribute as a Carbon date object to extract the month and year.
            $date = CarbonImmutable::createFromFormat('Y-m-d H:i:s', $item['spent_at']);
            // Group by month and year.
            return $date->format('Y-F');
        })->each(function ($month) {
            $totalExpenses = array_reduce($month->toArray(), function ($carry, $item) {
                return $carry + (float) $item['amount'];
            }, 0);

            return $month['sum'] = $totalExpenses;
        });
    }
}
