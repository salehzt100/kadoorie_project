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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('abstract')->nullable();
            $table->foreignId('faculty_department_id')
                ->constrained('faculty_departments')
                ->cascadeOnDelete();
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();
            $table->boolean('visibility')->default(true);
            $table->string('video')->nullable();
            $table->string('public_id_for_video')->nullable();
            $table->string('public_id_for_poster')->nullable();
            $table->string('public_id_for_thesis')->nullable();
            $table->string('thesis')->nullable();
            $table->string('poster')->nullable();
            $table->string('thesis_name')->nullable();
            $table->string('poster_name')->nullable();
            $table->string('thesis_type')->nullable();
            $table->string('poster_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
