<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('audit_projects')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('cobit_questions')->cascadeOnDelete();
            $table->enum('answer', ['Y', 'N']); // Yes = aktivitas diterapkan, No = belum
            $table->text('notes')->nullable();
            $table->string('evidence_file')->nullable();
            $table->timestamps();

            $table->unique(['project_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_responses');
    }
};
