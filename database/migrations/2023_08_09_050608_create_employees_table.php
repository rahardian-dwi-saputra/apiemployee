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
        Schema::create('employees', function (Blueprint $table) {
            $table->string('employee_id', 20);
            $table->string('full_name');
            $table->unsignedBigInteger('job_id');
            $table->date('hire_date');
            $table->string('gender', 1);
            $table->date('date_of_birth');
            $table->string('email')->nullable();
            $table->string('phone', 20);
            $table->text('address')->nullable();
            $table->decimal('salary',8,2)->nullable();
            
            $table->primary('employee_id');
            $table->foreign('job_id')->references('id')->on('jobs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
