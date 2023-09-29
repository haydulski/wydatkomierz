<?php

namespace Tests\Feature\Livewire;

use App\Livewire\{CreateNote, Charts, Download, EditNote, Home, UserNotes};
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ViewsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(1);
    }

    public function testUserNotesView(): void
    {
        Livewire::actingAs($this->user)
            ->test(UserNotes::class)
            ->assertSee('John Doe');
    }

    public function testHomePageView(): void
    {
        Livewire::actingAs($this->user)
            ->test(Home::class)
            ->assertSee('Cześć John!')
            ->assertSee('Twój email: john.doe@gmail.com');
    }

    public function testChartsView(): void
    {
        Livewire::actingAs($this->user)
            ->test(Charts::class)
            ->assertSee('Wydatki miesięcznie');
    }

    public function testDownloadView(): void
    {
        Livewire::actingAs($this->user)
            ->test(Download::class)
            ->assertSee('Wybierz typ');
    }

    public function testCreateNoteView(): void
    {
        Livewire::actingAs($this->user)
            ->test(CreateNote::class)
            ->assertSee('Dodaj');
    }

    public function testEditNoteView(): void
    {
        $expense = Expense::find(1);

        Livewire::actingAs($this->user)
            ->test(EditNote::class, ['expense' => $expense])
            ->assertSee('Zmień')
            ->assertSee($expense->title);
    }
}
