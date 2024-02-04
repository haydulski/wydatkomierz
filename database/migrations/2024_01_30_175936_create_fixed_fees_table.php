<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fixed_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('category_id')->constrained('categories', 'id');
            $table->integer('type');
            $table->string('title', 100);
            $table->float('amount');
            $table->timestamp('date_last_added')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'category_id']);
            $table->index(['user_id', 'spent_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_fees');
    }
};
