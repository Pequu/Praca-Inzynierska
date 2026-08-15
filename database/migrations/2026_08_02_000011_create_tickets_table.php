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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reservation_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('screening_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('seat_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('qr_code')->unique();

            $table->enum('status', [
                'valid',
                'used',
                'cancelled'
            ])->default('valid');

            // The timestamp when the ticket was used (if applicable)
            $table->timestamp('used_at')->nullable();

            $table->decimal('ticket_price', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
