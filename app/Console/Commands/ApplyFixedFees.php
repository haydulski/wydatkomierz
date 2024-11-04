<?php

namespace App\Console\Commands;

use App\Enums\FixedFeesTypes;
use App\Models\Expense;
use App\Models\FixedFee;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ApplyFixedFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:apply-fixed-fees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ckeck and add if applied fees to expenses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fees = FixedFee::all();

        $fees->each(function ($fee) {
            switch ($fee->type->name) {
                case FixedFeesTypes::Daily->name:
                    $this->addFeeDependingOnDaysInterval($fee, 0);
                    break;
                case FixedFeesTypes::Weekly->name:
                    $this->addFeeDependingOnDaysInterval($fee, 7);
                    break;
                case FixedFeesTypes::Monthly->name:
                    $interval = 31;
                    if ((new DateTime('now'))->format('F') === 'March') {
                        $interval = 28;
                    }

                    $this->addFeeDependingOnDaysInterval($fee, $interval);
                    break;
                case FixedFeesTypes::Yearly->name:
                    $this->addFeeDependingOnDaysInterval($fee, 365);
                    break;
            }
        });

        Cache::flush();
    }

    private function addFeeDependingOnDaysInterval(FixedFee $fee, int $days): void
    {
        $date = new DateTime('now');
        $lastFeeUpdate = $fee->date_last_added;

        if (! $lastFeeUpdate) {
            $this->createExpense($fee, $date);
        }
        $interval = (new DateTime($lastFeeUpdate))->diff($date);

        if ($interval->days > $days) {
            $this->createExpense($fee, $date);
        }
    }

    private function createExpense(FixedFee $fee, DateTime $date): void
    {
        DB::transaction(function () use ($fee, $date) {
            Expense::create(
                [
                    'title' => $fee->title,
                    'amount' => (float) $fee->amount,
                    'spent_at' => $date->format('Y-m-d H:i:s'),
                    'category_id' => $fee->category_id,
                    'info' => 'Stały wydatek',
                    'user_id' => $fee->user_id,
                ]
            );

            $fee->update(['date_last_added' => $date->format('Y-m-d H:i:s')]);
        });
    }
}
