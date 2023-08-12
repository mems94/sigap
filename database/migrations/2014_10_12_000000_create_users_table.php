<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('login');
            $table->string('password');
            $table->string('role');            
            $table->rememberToken();
            $table->timestamps();

            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            
        });

        Schema::table('employees', function(Blueprint $table){
            $table->foreignIdFor(User::class);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
