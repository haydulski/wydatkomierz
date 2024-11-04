<?php

use App\Livewire\Charts;
use App\Livewire\CommonNotes;
use App\Livewire\CreateNote;
use App\Livewire\Download;
use App\Livewire\EditNote;
use App\Livewire\FixedFeeAdd;
use App\Livewire\FixedFeeEdit;
use App\Livewire\FixedFees;
use App\Livewire\Home;
use App\Livewire\Login;
use App\Livewire\UserNotes;
use Illuminate\Support\Facades\Route;

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
    Route::get('/statystyki/{yearString}', Charts::class)->name('user.charts');
    Route::get('/raporty', Download::class)->name('user.download');
    Route::get('/stale-wydatki', FixedFees::class)->name('user.fees');
    Route::get('/stale-wydatki/nowy', FixedFeeAdd::class)->name('user.fees.add');
    Route::get('/stale-wydatki/edycja/{fee}', FixedFeeEdit::class)->name('user.fees.edit');
    Route::get('/wspolne-wydatki', CommonNotes::class)->name('user.notes.common');
});
