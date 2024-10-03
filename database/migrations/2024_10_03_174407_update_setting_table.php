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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('company_tva')->nullable();
            $table->string('company_icon')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('company_tva');
            $table->dropColumn('company_icon');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });
    }
};
