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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'workout' ou 'plan'
            $table->integer('status')->default(0);

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('stripe_session_id')->nullable();
            $table->foreignId('reduction_id')->nullable()->constrained();

            // Champs pour la relation polymorphique
            // $table->unsignedBigInteger('orderable_id');
            // $table->string('orderable_type');

            $table->decimal('total_price', 8, 2);
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
