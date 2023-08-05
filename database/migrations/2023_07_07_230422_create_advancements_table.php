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
        Schema::create('advancements', function (Blueprint $table) {
            $table->id();
            $table->String('class');
            $table->integer('echelon');
            $table->integer('indice');
            $table->String('category');
            //insertion foreign_key for employee
            $table->unsignedBigInteger('employee_im');
            $table->foreign('employee_im')->references('im')->on('employees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advancements');
    }
};
