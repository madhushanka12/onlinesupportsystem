<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('casts', static function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('stage_name');
            $table->string('real_name');
            $table->string('slug')->unique();
            $table->longText('image');
            $table->boolean('is_active')->default(true);
            $table->foreignIdFor(User::class, 'added_by')->constrained('users');
            $table->foreignIdFor(User::class, 'modified_by')->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casts');
    }
};
