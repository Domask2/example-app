<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_sources', function (Blueprint $table) {
            $table->id();

            $table->foreignId('data_base_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title', 50);
            $table->string('key', 50)->index();
            $table->string('description', 2048)->nullable();
            $table->string('type', 10)->comment('Table|View');
            $table->string('crud', 4)->comment('Available methods (CREATE, READ, UPDATE, DELETE');

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
        Schema::dropIfExists('data_sources');
    }
}
