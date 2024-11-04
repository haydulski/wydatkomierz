<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Expense;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class CommonNotes extends Component
{
    private const CACHE_TTL = 7200;

    private const DB_DATE_FORMAT = 'Y-m-d H:i:s';

    private CarbonImmutable $dateFrom;

    private CarbonImmutable $dateTo;

    private Collection $rawExpenses;

    private string $cacheKey;

    public User $user;

    public array $additionalValues = ['sum', 'expensers'];

    public array $expenses;

    public string $currentYear;

    public string $previousYear;

    public function mount(string $year = null)
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
        $this->cacheKey = "$this->currentYear-common-expenses";

        $this->rawExpenses = Cache::remember(
            $this->cacheKey,
            self::CACHE_TTL,
            fn() => $this->getFormatedExpenses()
        );
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

    public function render()
    {
        return view('livewire.user-notes-common')->layoutData(['title' => 'Wspólne wydatki']);
    }

    private function getFormatedExpenses()
    {
        $expensesRaw = Expense::with('user')
            ->where('is_common', true)
            ->getExpensesBetween($this->dateFrom, $this->dateTo)
            ->get();

        return $expensesRaw->groupBy(function ($item) {
            $date = CarbonImmutable::createFromFormat(self::DB_DATE_FORMAT, $item['spent_at']);
            // Group by month and year.
            return $date->format('Y-F');
        })->each(function ($month) {
            $totalExpenses = array_reduce($month->toArray(), function ($carry, $item) {
                return $carry + (float) $item['amount'];
            }, 0);
            $month['expensers'] = $this->getExpenseSumByUser($month);

            return $month['sum'] = $totalExpenses;
        });
    }

    private function getExpenseSumByUser(Collection $month): array
    {
        $output = $month;

        return $output->groupBy('user.first_name')
            ->map(fn($expense) => $expense->sum('amount'))
            ->toArray();
    }
}
