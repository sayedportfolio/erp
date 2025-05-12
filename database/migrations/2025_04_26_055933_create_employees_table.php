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
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('pin_code')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('last_qualification')->nullable();
            $table->bigInteger('aadhar_number')->nullable();
            $table->bigInteger('pan_number')->nullable();
            $table->bigInteger('bank_account_number')->nullable();
            $table->string('bank_ifsc_code')->nullable();
            $table->string('qualification_certificate')->nullable();
            $table->string('aadhar_certificate')->nullable();
            $table->string('pan_cerificate')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->boolean('status')->default(1);
            $table->timestamps();
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
