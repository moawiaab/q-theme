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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone',30)->nullable();
            $table->unsignedBigInteger('role_id')->references('id')->on('roles')->nullable();
            $table->unsignedBigInteger('account_id')->references('id')->on('accounts')->nullable();
            $table->tinyText('local')->default('ar');
            $table->tinyInteger('status')->default(1);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
