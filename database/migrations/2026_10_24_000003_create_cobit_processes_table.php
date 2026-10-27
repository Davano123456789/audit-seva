<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cobit_processes', function (Blueprint $table) {
            $table->string('code', 10)->primary(); // APO07, BAI09, DSS05
            $table->string('domain_id', 10);
            $table->string('name');                // Managed Human Resources
            $table->text('description')->nullable(); // Pengelolaan SDM TI
            $table->timestamps();

            $table->foreign('domain_id')->references('id')->on('cobit_domains')
                ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cobit_processes');
    }
};
