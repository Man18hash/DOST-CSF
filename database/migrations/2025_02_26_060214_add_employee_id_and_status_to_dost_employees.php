<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('dost_employees', function (Blueprint $table) {
            $table->string('employee_id')->after('name')->unique()->nullable();
            $table->enum('status', ['Active', 'Inactive'])->after('employee_id')->default('Active');
        });
    }

    public function down()
    {
        Schema::table('dost_employees', function (Blueprint $table) {
            $table->dropColumn(['employee_id', 'status']);
        });
    }
};
