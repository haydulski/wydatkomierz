<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $casts = [
        'spent_at' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'amount',
        'spent_at',
        'category_id',
        'info',
        'user_id',
        'is_common',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGetExpensesBetween(Builder $query, string $start, string $end): void
    {
        $query->with('category:name,id')
            ->latest('spent_at')
            ->whereBetween('spent_at', [$start, $end]);
    }
}
