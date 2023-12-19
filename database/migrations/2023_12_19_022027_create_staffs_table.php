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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id('staff_id');
            $table->unsignedBigInteger('group_id');
            $table->string('staff_id_rw')->unique();
            $table->string('staff_name');
            $table->string('dept_id');
            $table->string('dept_name');
            $table->string('status');
            $table->timestamps();
            $table->foreign('group_id')->references('group_id')->on('groups');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};
