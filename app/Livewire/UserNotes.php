<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Expense;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class UserNotes extends Component
{
    private const CACHE_TTL = 7200;

    private const DB_DATE_FORMAT = 'Y-m-d H:i:s';

    private CarbonImmutable $dateFrom;

    private CarbonImmutable $dateTo;

    private Collection $rawExpenses;

    public User $user;

    public array $expenses;

    public string $currentYear;

    public string $previousYear;


    public function mount(?string $year = null)
    {
        $this->user = auth()->user();

        if ($year === null || $year === CarbonImmutable::now()->format('Y')) {
            $this->dateFrom = CarbonImmutable::now()->startOfYear();
            $this->dateTo = CarbonImmutable::now();
        } else {
            $this->dateFrom = CarbonImmutable::create($year)->startOfYear();
            $this->dateTo = CarbonImmutable::create($year)->endOfYear();
        }

        $this->currentYear = $this->dateTo->format('Y');
        $this->previousYear = $this->dateTo->subYear()->format('Y');

        $this->rawExpenses = $this->getFormatedExpenses();
        // we not allowed to load on livewire 3.4 front Collection object
        $this->expenses = $this->rawExpenses->toArray();
    }

    public function prevYear(string $year): void
    {
        $year !== 'now' ? $this->mount($year) : $this->mount(null);
    }

    public function groupBy(string $type, string $year)
    {
        $this->mount($year);
        $sortedArray = [];

        foreach ($this->rawExpenses as $key => $subCollection) {
            $sortedArray[$key] = $subCollection->sortByDesc($type)->toArray();
        }

        $this->expenses = $sortedArray;
    }

    public function delete(int $id, string $year)
    {
        $note = Expense::find($id);
        $note->delete();
        Cache::flush();

        $this->mount($year);
    }

    public function render()
    {
        return view('livewire.user-notes');
    }

    private function getFormatedExpenses()
    {
        $expensesRaw = $this->user->getExpensesBetween($this->dateFrom, $this->dateTo)
            ->first()->expenses;

        $sortedExpenses = $expensesRaw->groupBy(function ($item) {
            $date = CarbonImmutable::createFromFormat(self::DB_DATE_FORMAT, $item['spent_at']);
            // Group by month and year.
            return $date->format('Y-F');
        })->each(function ($month) {
            $totalExpenses = array_reduce($month->toArray(), function ($carry, $item) {
                return $carry + (float) $item['amount'];
            }, 0);

            return $month['sum'] = $totalExpenses;
        });

        return Cache::remember(
            "$this->currentYear-expenses-" . $this->user->id,
            self::CACHE_TTL,
            fn () => $sortedExpenses
        );
    }
}
