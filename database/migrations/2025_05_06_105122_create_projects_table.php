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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('project_category_id')->constrained('project_categories')->onDelete('cascade');
            $table->enum('type', ['regular', 'custom']);
            $table->foreignId('regular_project_id')->constrained('reguler_projects')->onDelete('cascade');
            $table->decimal('budget', 12, 2)->default(0.00);
            $table->enum('payment_type', ['advance', 'full payment', 'partial', 'installment', 'final settlement']);
            $table->foreignId('project_manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('start_date')->nullable();
            $table->date('expected_end_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->integer('delay')->default(0)->comment('Delay in days');
            $table->decimal('cost', 12, 2)->default(0.00);
            $table->decimal('paid', 12, 2)->default(0.00);
            $table->decimal('due', 12, 2)->default(0.00);
            $table->enum('status', ['active', 'inactive', 'completed', 'rejected'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
