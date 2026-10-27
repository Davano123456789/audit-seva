<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('asesor_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['draft', 'in_progress', 'completed'])->default('draft');
            $table->decimal('maturity_index', 3, 2)->nullable(); // rata-rata capability level, contoh 2.83
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_projects');
    }
};
