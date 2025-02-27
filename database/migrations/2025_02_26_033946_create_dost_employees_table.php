<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dost_employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('unit_provider_id')->constrained('unit_providers')->onDelete('cascade');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('dost_employees');
    }
};

