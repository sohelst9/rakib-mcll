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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('category_id');
            $table->string('file')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('banner')->nullable();
            $table->longText('description')->nullable();
            $table->date('start_date')->nullable(); 
            $table->date('end_date')->nullable();  
            $table->decimal('entry_fee', 10, 2)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
