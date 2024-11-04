<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use App\Livewire\Charts;
use App\Livewire\CreateNote;
use App\Livewire\Download;
use App\Livewire\EditNote;
use App\Livewire\Home;
use App\Livewire\UserNotes;
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
            ->test(Charts::class, ['yearString' => '2023'])
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

    public function testEditNoteRedirect(): void
    {
        $expense = Expense::find(1);

        Livewire::actingAs($this->user)
            ->test(EditNote::class, ['expense' => $expense])
            ->set('title', 'Using a redirect')
            ->call('change')
            ->assertRedirect(route('user.notes'));
    }
}
