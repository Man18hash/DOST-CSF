<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_settings', function (Blueprint $table) {
            $table->id();
            $table->text('fields'); // JSON field to store form structure
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_settings');
    }
};

