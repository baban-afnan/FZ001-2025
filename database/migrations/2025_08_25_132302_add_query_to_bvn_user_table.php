<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusEnumInNinverificationsTable extends Migration
{
    public function up()
    {
        Schema::table('ninverifications', function (Blueprint $table) {
            // If you're using ENUM
            $table->enum('status', ['pending', 'resolved', 'verified', 'failed'])
                  ->default('pending')
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('ninverifications', function (Blueprint $table) {
            $table->enum('status', ['pending', 'resolved', 'failed'])
                  ->default('pending')
                  ->change();
        });
    }
}
