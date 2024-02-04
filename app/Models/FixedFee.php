<?php

namespace App\Models;

use App\Enums\FixedFeesTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FixedFee extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => FixedFeesTypes::class
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
