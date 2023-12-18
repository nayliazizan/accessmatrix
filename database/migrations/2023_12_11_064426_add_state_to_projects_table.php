<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Add the following lines to the up() method
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('state', ['active', 'inactive'])->default('active')->after('project_desc');
        });
    }

    // Add the following lines to the down() method
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('state');
        });
    }

};
