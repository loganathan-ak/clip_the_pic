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
        Schema::create('sub_orders', function (Blueprint $table) {
            
            $table->id();

            $table->foreignId('credits_bd_id')->constrained('credits_usages')->onDelete('cascade');

            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');

            $table->string('job_id');

            $table->string('project_title');
            
            $table->string('request_type');

            $table->string('sub_services')->nullable();

            $table->string('duration')->nullable();
        
            $table->text('instructions')->nullable();

            $table->text('admin_notes')->nullable();

            $table->string('colors')->nullable();
        
            $table->string('size')->nullable();

            $table->string('other_size')->nullable();

            $table->json('formats')->nullable(); // From checkbox input
        
            $table->json('reference_files')->nullable(); // Store paths or filenames

            $table->foreignId('assigned_to')->nullable();

            $table->string('completed_at')->nullable();
        
            $table->string('status')->default('pending'); // optional default

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_orders');
    }
};
