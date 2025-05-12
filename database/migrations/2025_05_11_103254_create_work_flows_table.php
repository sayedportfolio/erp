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
        Schema::create('work_flows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_flow_template_id')->constrained('work_flow_templates')->onDelete('cascade');
            $table->string('name');
            $table->json('steps'); // [{step_id, task_id, status, assignee_id, due_date, notification_sent, buttons}]
            $table->timestamp('start_date')->nullable();
            $table->foreignId('work_flows_id')->nullable()->constrained('work_flows')->onDelete('set null');
            $table->string('parent_step_id')->nullable();
            $table->json('trigger_conditions')->nullable();
            $table->json('context_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_flows');
    }
};
