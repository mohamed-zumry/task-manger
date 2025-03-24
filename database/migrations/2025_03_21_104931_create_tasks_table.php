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

            // Name of the Task
            $table->string('name', 100);

            // Task Priority Level
            $table->integer('priority')->default(0);

            // Task Description
            $table->text('description')->nullable();

            // Start Date of the Task
            $table->date('start_date')->nullable();

            // Task Created and Updated time
            $table->timestamps();

            // Task status
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->index('priority');
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
