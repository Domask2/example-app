<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSourceAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_source_accesses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('data_source_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('key', 50)->index();
            $table->string('source_name', 50);
            $table->string('role', 15)->default('user');

            $table->unique(['role', 'key']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_sources_accesses');
    }
}
