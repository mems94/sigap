<?php

use App\Models\Contract;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->String('contractNumber');
            $table->String('contractType'); //EFA, ELD, ECD
            $table->date('startDate');
            $table->date('endDate');
            $table->String('projectContractFilePath');
              //insertion foreign_key for employee
            $table->unsignedBigInteger('employee_im');
            $table->foreign('employee_im')->references('im')->on('employees')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('avenants', function(Blueprint $table){
            $table->foreignIdFor(Contract::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
