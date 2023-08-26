<?php

use App\Http\Middleware\GlobalLoginCheck;
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
Route::middleware(GlobalLoginCheck::class)->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/lista/{user}', UserNotes::class)->name('user.notes');
    Route::get('/dodaj-wydatek/{user}', CreateNote::class)->name('user.notes.new');
    Route::get('/edytuj-wydatek/{expense}/{user}', EditNote::class)->name('user.notes.edit');
    Route::get('/statystyki/{user}', Charts::class)->name('user.charts');
    Route::get('/raporty/{user}', Download::class)->name('user.download');
});
