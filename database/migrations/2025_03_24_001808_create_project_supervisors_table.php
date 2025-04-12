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
        Schema::create('project_supervisors', function (Blueprint $table) {
            $table->primary(['project_id', 'supervisor_id']);
            $table->foreignId('project_id')
                ->constrained('projects')
                ->onDelete('cascade');
            $table->foreignId('supervisor_id')
                ->constrained('supervisors')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_supervisors');
    }
};
