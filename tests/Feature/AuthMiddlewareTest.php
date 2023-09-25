<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AuthMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanAccessProtectedRoute()
    {
        // Define a route that is protected by your authentication middleware
        Route::get('/protected-route', function () {
            return 'This is a protected route.';
        })->middleware('auth');

        // Create a user and simulate authentication
        $user = User::find(1);

        // Ensure the user is authenticated and can access the protected route
        $this->actingAs($user)
            ->get('/protected-route')
            ->assertStatus(200)
            ->assertSee('This is a protected route.');
    }

    public function testGuestCannotAccessProtectedRoute()
    {
        Route::get('/protected-route', function () {
            return 'This is a protected route.';
        })->middleware('auth');

        $this->get('/protected-route')
            ->assertStatus(302) // Redirected to login page
            ->assertRedirect('/login');
    }
}
