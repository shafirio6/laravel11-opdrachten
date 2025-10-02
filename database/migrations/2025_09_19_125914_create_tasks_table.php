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
            $table->string('task', 200);
            $table->date('begindate')->nullable();
            $table->date('enddate')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()
                ->onUpdate('no action')->onDelete('no action');
            $table->foreignId('project_id')->constrained()
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('activity_id')->constrained()
                ->restrictOnUpdate()->restrictOnDelete();
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
