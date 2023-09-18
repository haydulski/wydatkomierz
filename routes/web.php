<?php

use App\Livewire\Charts;
use Illuminate\Support\Facades\Route;
use App\Livewire\CreateNote;
use App\Livewire\Download;
use App\Livewire\EditNote;
use App\Livewire\Home;
use App\Livewire\Login;
use App\Livewire\UserNotes;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/lista', UserNotes::class)->name('user.notes');
    Route::get('/dodaj-wydatek', CreateNote::class)->name('user.notes.new');
    Route::get('/edytuj-wydatek/{expense}', EditNote::class)->name('user.notes.edit');
    Route::get('/statystyki', Charts::class)->name('user.charts');
    Route::get('/raporty', Download::class)->name('user.download');
});
