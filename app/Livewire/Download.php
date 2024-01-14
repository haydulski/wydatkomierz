<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Contracts\DataBuilderInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Download extends Component
{
    private DataBuilderInterface $factory;

    public string $annualRaportYear;

    public string $fileType = 'xml';

    public int $month = 1;

    public array $months;

    public int $raportType;

    #[Locked]
    public User $user;

    public string $year;

    public array $raportTypes = [
        1 => 'Roczny',
        2 => 'Miesięczny',
        3 => 'Wszystkie lata'
    ];

    public function boot(DataBuilderInterface $factory)
    {
        $this->factory = $factory;
    }

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->year = Carbon::now()->format('Y');
        $this->annualRaportYear = Carbon::now()->format('Y');
        $this->months = range(1, 12, 1);
    }

    public function render(): View
    {
        return view('livewire.download');
    }

    public function chooseRaport(int $id): void
    {
        $this->raportType = $id;
    }

    public function downloadAnnualRaport(): ?StreamedResponse
    {
        $date = Carbon::create($this->annualRaportYear)->startOfYear();

        $data = $this->user->expenses()
            ->where('spent_at', '>', $date)
            ->with('category:id,name')
            ->orderBy('spent_at')
            ->get();

        if ($data->count() < 1) {
            session()->flash('status', 'Brak danych dla wybranego okresu!');
            return $this->redirectRoute('user.download');
        }

        $builder = $this->factory->create($this->fileType);
        $builder->collectData($data->toArray());
        $filename = 'wydatki-raport_za_' . $date->format('Y') . '.' . $builder->getFileFormat();

        return response()->streamDownload(function () use ($builder) {
            echo $builder->getParsedData();
        }, $filename);
    }

    public function downloadMonthRaport(): ?StreamedResponse
    {
        $date = Carbon::createFromFormat('Y/m', "$this->annualRaportYear/$this->month");

        $data = $this->user->expenses()
            ->with('category:id,name')
            ->whereBetween(
                'spent_at',
                [$date->startOfMonth()->format('Y-m-d H:i:s'), $date->endOfMonth()->format('Y-m-d H:i:s')]
            )
            ->orderBy('spent_at')
            ->get();

        if ($data->count() < 1) {
            session()->flash('status', 'Brak danych dla wybranego okresu!');
            return $this->redirectRoute('user.download');
        }

        $builder = $this->factory->create($this->fileType);
        $builder->collectData($data->toArray());
        $filename = 'wydatki-raport_za_' . $date->format('Y-m') . '.' . $builder->getFileFormat();

        return response()->streamDownload(function () use ($builder) {
            echo $builder->getParsedData();
        }, $filename);
    }

    public function downloadAllYearsRaport(): StreamedResponse
    {
        $data = $this->user->expenses()
            ->with('category:id,name')
            ->orderBy('spent_at')
            ->get();

        if ($data->count() < 1) {
            session()->flash('status', 'Brak danych dla wybranego okresu!');
            return $this->redirectRoute('user.download');
        }

        $builder = $this->factory->create($this->fileType);
        $builder->collectData($data);
        $filename = 'wydatki-raport_wszystkie_lata' . '.' . $builder->getFileFormat();

        return response()->streamDownload(function () use ($builder) {
            echo $builder->getParsedData();
        }, $filename);
    }
}
