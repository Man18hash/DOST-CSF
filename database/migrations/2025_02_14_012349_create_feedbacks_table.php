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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('age');
            $table->enum('sex', ['Male', 'Female']);
            $table->string('address');
            $table->json('client_classification'); // still JSON, though it will now contain a single string
            $table->enum('client_type', ['Internal', 'External']);
            $table->date('date');
            $table->string('CC1');
            $table->string('CC2')->nullable();
            $table->string('CC3')->nullable();
            $table->unsignedBigInteger('office_id');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->string('unit_provider');
            $table->string('assistance_availed');
            $table->string('DOST_employee')->nullable();
            $table->string('SQD0');
            $table->string('SQD1');
            $table->string('SQD2');
            $table->string('SQD3');
            $table->string('SQD4');
            $table->string('SQD5');
            $table->string('SQD6');
            $table->string('SQD7');
            $table->string('SQD8');
            $table->text('suggestions')->nullable();
            $table->integer('recommendation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
