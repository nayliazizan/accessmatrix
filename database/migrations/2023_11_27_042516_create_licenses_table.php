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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id('license_id'); // Adjusted to match your design
            $table->string('license_name', 100)->unique();
            $table->text('license_desc')->nullable();
            //$table->timestamp('time_created')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            //$table->timestamp('time_updated')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            //$table->foreignId('created_by')->constrained('users', 'user_id');
            //$table->foreignId('updated_by')->constrained('users', 'user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
