<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIndexToDataSourceAccesses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_source_accesses', function (Blueprint $table) {
            $table->dropUnique(['role', 'key']);
            $table->unique(['role', 'data_source_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_source_accesses', function (Blueprint $table) {
            $table->unique(['role', 'key']);
            $table->dropUnique(['role', 'data_source_id']);
        });
    }
}
