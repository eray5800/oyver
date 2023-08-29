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
       
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pool_id');
            $table->string('name');
            $table->timestamps();
            $table->foreign('pool_id')->references('id')->on('pools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
