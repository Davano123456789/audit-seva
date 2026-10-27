<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cobit_practices', function (Blueprint $table) {
            $table->string('code', 15)->primary(); // APO07.01
            $table->string('process_code', 10);
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('process_code')->references('code')->on('cobit_processes')
                ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cobit_practices');
    }
};
