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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('age');
            $table->enum('sex', ['Male', 'Female']);
            $table->string('address');
            $table->json('client_classification'); // Stores multiple selections
            $table->enum('client_type', ['Internal', 'External']);
            $table->date('date');
            $table->string('CC1');
            $table->string('CC2')->nullable();
            $table->string('CC3')->nullable();
            $table->string('unit_provider');
            $table->string('assistance_availed');
            $table->string('DOST_employee');
            $table->integer('SQD0');
            $table->integer('SQD1');
            $table->integer('SQD2');
            $table->integer('SQD3');
            $table->integer('SQD4');
            $table->integer('SQD5');
            $table->integer('SQD6');
            $table->integer('SQD7');
            $table->integer('SQD8');
            $table->text('suggestions')->nullable();
            $table->integer('recommendation'); // Rating scale from 1-10
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
