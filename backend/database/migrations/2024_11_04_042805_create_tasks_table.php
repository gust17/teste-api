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
            $table->text('description')->nullable();
            $table->enum('status', ['pendente', 'em_andamento', 'concluída'])->default('pendente');
            $table->enum('priority', ['baixa', 'media', 'alta'])->default('media');
            $table->timestamp('deadline')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relacionamento com usuário
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
