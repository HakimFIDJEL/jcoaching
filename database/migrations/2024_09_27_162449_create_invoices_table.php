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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();

            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            $table->string('path')->nullable();
            $table->string('filename')->nullable();
            $table->string('type')->nullable();
            $table->string('size')->nullable();
            $table->string('extension')->nullable();
            $table->string('mime_type')->nullable();


            $table->boolean('is_cancelled')->default(false);
            $table->text('cancellation_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
