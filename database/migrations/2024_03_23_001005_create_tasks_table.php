<?php

use App\Enums\TaskPriority;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('status_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate();
            $table->string('title', 255);
            $table->string('description', 1000)
                ->nullable();
            $table->enum('priority', TaskPriority::values());
            $table->date('due_at')
                ->nullable();
            $table->date('completed_at')
                ->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
