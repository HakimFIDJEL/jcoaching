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
        Schema::create('chatbox_message_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chatbox_message_id')->constrained()->onDelete('cascade');
            $table->string('filename');
            $table->string('path');
            $table->string('type');
            $table->string('size');
            $table->string('extension');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbox_message_files');
    }
};
