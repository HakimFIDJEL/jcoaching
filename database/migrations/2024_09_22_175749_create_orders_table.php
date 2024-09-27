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
            // Identifiants & références de la commande
            $table->id();
            $table->string('reference')->unique();

            // Informations sur la commande
            $table->string('product_type'); 
            $table->string('product_name');
            $table->integer('product_quantity');
            $table->decimal('product_price', 8, 2);

            $table->decimal('price_ht', 8, 2);
            $table->decimal('price_ttc', 8, 2);
            $table->decimal('taxes', 8, 2);
            $table->string('currency')->default('EUR');
            $table->text('description');
            
            // Informations sur l'utilisateur
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('customer_firstname');
            $table->string('customer_lastname');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->string('customer_city');
            $table->string('customer_postal_code');
            $table->string('customer_country');
            
            
            // Informations sur le paiement
            $table->string('payment_method')->default('stripe');
            $table->string('stripe_session_id')->nullable();
            $table->integer('status')->default(0);
            $table->foreignId('reduction_id')->nullable()->constrained();
            $table->string('ip_address')->nullable();

            $table->timestamp('cgv_terms_accepted_at')->nullable();
            $table->timestamp('rgpd_terms_accepted_at')->nullable();

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
