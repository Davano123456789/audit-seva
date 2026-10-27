<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cobit_questions', function (Blueprint $table) {
            $table->id();
            $table->string('practice_code', 15);
            $table->unsignedTinyInteger('level'); // capability level 2 - 5
            $table->text('question_text');
            $table->text('expected_evidence')->nullable(); // bukti hasil kerja yang diharapkan
            $table->timestamps();

            $table->foreign('practice_code')->references('code')->on('cobit_practices')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->index(['practice_code', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cobit_questions');
    }
};
