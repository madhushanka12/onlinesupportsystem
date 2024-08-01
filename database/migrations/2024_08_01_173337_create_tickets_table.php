<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tickets', static function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('reference_number')->unique();
            $table->string('name');
            $table->longText('problem');
            $table->string('email');
            $table->string('mobile')->nullable();
            $table->longText('reply')->nullable();
            $table->enum('status', ['pending', 'complete'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
