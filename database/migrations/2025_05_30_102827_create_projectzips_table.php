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
        Schema::create('projectzips', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('order_id');
            $table->string('job_id');
            $table->string('file_path'); // Add this if you're storing file paths
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projectzips');
    }
};
