<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function fees(): HasMany
    {
        return $this->hasMany(FixedFee::class);
    }

    public function scopeGetYearExpensesByMonths(Builder $query, string $year): void
    {
        $query->selectRaw('strftime("%m",spent_at) as month, sum(amount) as totalByMonth, spent_at')
            ->join('expenses', 'expenses.user_id', '=', 'users.id')
            ->where('spent_at', '>', $year)
            ->groupBy('month');
    }

    public function scopeGetYearExpensesByCategory(Builder $query, string $year): void
    {
        $query->selectRaw(
            'categories.id, categories.name, expenses.category_id, sum(expenses.amount) as totalByCategory'
        )
            ->join('expenses', 'expenses.user_id', '=', 'users.id')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->where('spent_at', '>', $year)
            ->groupBy('expenses.category_id');
    }

    public function scopeGetMonthExpensesByCategory(Builder $query, string $year): void
    {
        $query->selectRaw(
            'categories.id, categories.name, expenses.category_id, sum(expenses.amount) as totalByCategory'
        )
            ->join('expenses', 'expenses.user_id', '=', 'users.id')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->where('spent_at', '>', $year)
            ->groupBy('expenses.category_id');
    }
}
