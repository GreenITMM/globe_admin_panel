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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->text('job_responsibility');
            $table->text('job_requirement');
            $table->integer('salary')->default(0);
            $table->text('contact_mail')->nullable();
            $table->text('call_phone')->nullable();
            $table->text('viber_phone')->nullable();
            $table->text('office_location')->nullable();
            $table->text('working_time')->nullable();
            $table->text('off_days')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
