<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Charts extends Component
{
    #[Locked]
    public User $user;

    public Carbon $year;

    public array $totalCurrentYearExpensesByMonthMonths;

    public array $totalCurrentYearExpensesByMonthAmounts;

    public array $yearExpensesByCategoryLabels;

    public array $yearExpensesByCategoryValues;

    public array $monthExpensesByCategoryLabels;

    public array $monthExpensesByCategoryValues;

    public array $yearsToDisplay = ['2022', '2023', '2024'];

    public string $yearString;

    public function mount(string $yearString): void
    {
        $this->user = auth()->user();
        $this->yearString = $yearString;
        $this->year = new Carbon("$yearString-01-01 00:00:00");

        $this->getTotalCurrentYearExpensesByMonth();
        $this->getYearExpensesByCategory();
        $this->getMonthExpensesByCategory();
    }

    public function render(): View
    {
        return view('livewire.charts');
    }

    private function getTotalCurrentYearExpensesByMonth(): void
    {
        $data = $this->totalCurrentYearExpenses()->toArray();
        $this->totalCurrentYearExpensesByMonthAmounts = array_column($data, 'totalByMonth');

        foreach ($data as $month) {
            $this->totalCurrentYearExpensesByMonthMonths[] = decodeMonth((int) $month['month']);
        }
    }

    private function totalCurrentYearExpenses(): Collection
    {
        return Cache::remember(
            'charts-total-amount-monthly-' . $this->user->id . '-' . $this->yearString,
            300,
            fn () => $this->user->getYearExpensesByMonths($this->year)->get()
        );
    }

    private function getYearExpensesByCategory(): void
    {
        $data = Cache::remember(
            'charts-total-amount-by-category-yearly-' . $this->user->id . '-' . $this->yearString,
            300,
            fn () => $this->user->getYearExpensesByCategory($this->year)->get()
        );

        $data->each(function ($category) {
            $this->yearExpensesByCategoryLabels[] = $category->name;
        });

        $data->each(function ($category) {
            $this->yearExpensesByCategoryValues[] = $category->totalByCategory;
        });
    }

    private function getMonthExpensesByCategory(): void
    {
        $now = CarbonImmutable::now();
        $date = $now->startOfMonth()->setYear((int) $this->yearString);

        $data = Cache::remember(
            'charts-total-amount-by-category-month-' . $this->user->id . '-' . $this->yearString,
            300,
            fn () => $this->user->getMonthExpensesByCategory($date)->get()
        );

        $data->each(function ($category) {
            $this->monthExpensesByCategoryLabels[] = $category->name;
        });

        $data->each(function ($category) {
            $this->monthExpensesByCategoryValues[] = $category->totalByCategory;
        });
    }
}
