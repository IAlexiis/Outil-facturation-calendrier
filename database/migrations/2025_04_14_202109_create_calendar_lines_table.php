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
        Schema::create('calendar_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('calendar_id');
            
            $table->string('uid')->nullable();
            $table->string('title')->nullable(); 
            $table->text('description')->nullable();
            $table->dateTime('start'); 
            $table->dateTime('end');  
            $table->integer('duration_minutes')->nullable(); 
            $table->decimal('total_hours', 6, 2)->nullable();
            $table->string('location')->nullable(); 
            $table->string('status')->nullable(); 
            $table->boolean('is_billable')->default(true); 

         
            $table->decimal('hourly_rate', 8, 2)->nullable(); 
            $table->decimal('amount', 10, 2)->nullable(); 
            $table->decimal('tva_rate', 5, 2)->nullable(); 
            $table->decimal('tva_amount', 10, 2)->nullable(); 
            $table->decimal('total_with_tva', 10, 2)->nullable(); 

            $table->timestamps();

            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_lines');
    }
};
