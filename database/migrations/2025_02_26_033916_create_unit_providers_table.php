<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('unit_providers', function (Blueprint $table) {
            $table->id();
            $table->string('unit_name')->unique();
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade');
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('unit_providers');
    }
};
