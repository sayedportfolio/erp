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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('assignee')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('To-Do'); // To-Do, In-Progress, Done
            $table->foreignId('work_flow_id')->nullable()->constrained('work_flows')->onDelete('cascade');
            $table->timestamp('due_date')->nullable();
            $table->json('task_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
