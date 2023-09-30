<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use App\Livewire\Login;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLoginView()
    {
        Livewire::test(Login::class)
            ->assertSee('Twój email')
            ->assertSee('Zaloguj');
    }

    public function testEmailIsRequired()
    {
        Livewire::test(Login::class)
            ->set('user', '')
            ->set('password', '1234')
            ->call('login')
            ->assertHasErrors('email');
    }

    public function testPasswordIsRequired()
    {
        Livewire::test(Login::class)
            ->set('user', 'john@gmail.com')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors('password');
    }
}
