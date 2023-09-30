<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\User;
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

    public array $totalCurrentYearExpensesByMonthMonths;

    public array $totalCurrentYearExpensesByMonthAmounts;

    public array $yearExpensesByCategoryLabels;

    public array $yearExpensesByCategoryValues;

    public array $monthExpensesByCategoryLabels;

    public array $monthExpensesByCategoryValues;


    public function mount(): void
    {
        $this->user = auth()->user();
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
        $now = CarbonImmutable::now();

        return Cache::remember('charts-total-amount-currentyear-monthly-' . $this->user->id, 300, function () use ($now) {
            return $this->user->expenses()->where('spent_at', '>', $now->startOfYear())
                ->selectRaw('strftime("%m",spent_at) as month, sum(amount) as totalByMonth, spent_at')
                ->groupBy('month')
                ->get();
        });
    }

    private function getYearExpensesByCategory(): void
    {
        $now = CarbonImmutable::now();
        $data = Cache::remember('charts-total-amount-by-category-yearly-' . $this->user->id, 300, function () use ($now) {
            return $this->user->expenses()->where('spent_at', '>', $now->startOfYear())
                ->with('category:id,name')
                ->selectRaw('category_id, sum(amount) as totalByCategory')
                ->groupBy('category_id')
                ->get();
        });

        $data->each(function ($category) {
            $this->yearExpensesByCategoryLabels[] = $category->category->name;
        });

        $data->each(function ($category) {
            $this->yearExpensesByCategoryValues[] = $category->totalByCategory;
        });
    }

    private function getMonthExpensesByCategory(): void
    {
        $now = CarbonImmutable::now();
        $data = Cache::remember('charts-total-amount-by-category-month-' . $this->user->id, 300, function () use ($now) {
            return $this->user->expenses()->where('spent_at', '>', $now->startOfMonth())
                ->with('category:id,name')
                ->selectRaw('category_id, sum(amount) as totalByCategory')
                ->groupBy('category_id')
                ->get();
        });

        $data->each(function ($category) {
            $this->monthExpensesByCategoryLabels[] = $category->category->name;
        });

        $data->each(function ($category) {
            $this->monthExpensesByCategoryValues[] = $category->totalByCategory;
        });
    }
}
