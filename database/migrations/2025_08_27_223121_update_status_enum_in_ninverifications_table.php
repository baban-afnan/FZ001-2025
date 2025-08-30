<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusEnumInNinverificationsTable extends Migration
{
    public function up()
    {
        Schema::table('nin_verifications', function (Blueprint $table) {
            // If you're using ENUM
            $table->enum('status', ['pending', 'resolved', 'verified', 'failed'])
                  ->default('pending')
                  ->change();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nin_verifications', function (Blueprint $table) {
            //
        });
    }
};
