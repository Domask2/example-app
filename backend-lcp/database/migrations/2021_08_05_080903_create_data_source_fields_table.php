<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSourceFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_source_fields', function (Blueprint $table) {
            $table->id();

            $table->foreignId('data_source_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title', 50);
            $table->string('dataIndex', 50);
            $table->string('key', 50)->index();
            $table->boolean('visible');
            $table->string('type', 50);

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
        Schema::dropIfExists('data_source_fields');
    }
}
