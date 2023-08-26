<?php

namespace App\Console\Commands;

use App\Mail\RaportBackup;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AutoRaportMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-raport-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        $users->each(function ($user) {
            if ($user->expenses()->count() > 0) {
                Mail::to($user)->send(new RaportBackup($user));
            }
        });
    }
}
