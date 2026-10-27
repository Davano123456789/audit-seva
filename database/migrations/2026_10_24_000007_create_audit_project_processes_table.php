<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_project_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('audit_projects')->cascadeOnDelete();
            $table->string('process_code', 10);
            $table->unsignedTinyInteger('target_level')->default(3);
            $table->unsignedTinyInteger('computed_capability_level')->nullable(); // hasil akhir 0 - 5
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->timestamps();

            $table->foreign('process_code')->references('code')->on('cobit_processes')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['project_id', 'process_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_project_processes');
    }
};
