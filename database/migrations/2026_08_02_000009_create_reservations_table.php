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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('screening_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('status', [
                'pending',
                'confirmed',
                'cancelled'
            ])
            ->default('pending');

            // Dane Klienta z czasu zamówenia
            $table->string('customer_name');
            $table->string('customer_surname');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('payment_method');
            $table->string('terms_accepted');
            $table->string('privacy_policy_accepted');
            $table->string('marketing_accepted');

            $table->decimal('total_price', 8, 2);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
