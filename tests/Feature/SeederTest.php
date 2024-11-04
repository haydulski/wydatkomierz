<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function testUsers(): void
    {
        $users = User::all();

        $this->assertCount(1, $users);
        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
    }

    public function testExpenses(): void
    {
        $expenses = Expense::all();
        $categoriesCount = Category::count();

        $this->assertCount($categoriesCount * 10, $expenses);
    }

    public function testCategories(): void
    {
        $categoriesFromFile = json_decode(file_get_contents(public_path('categories.json')), true);

        $this->assertDatabaseHas('categories', [
            'name' => $categoriesFromFile[0]['name'],
            'name' => $categoriesFromFile[1]['name'],
            'name' => $categoriesFromFile[2]['name'],
        ]);
    }
}
