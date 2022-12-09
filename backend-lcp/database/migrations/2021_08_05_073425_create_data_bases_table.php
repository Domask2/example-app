<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_bases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title', 50);
            $table->string('key', 50)->index();
            $table->string('description')->nullable();
            $table->string('driver', 10);
            $table->string('host', 100)->nullable();
            $table->string('port', 6)->nullable();
            $table->string('database', 50);
            $table->string('username', 50);
            $table->string('password', 50)->nullable();
            $table->string('charset', 20);
            $table->string('prefix', 50)->nullable();
            $table->boolean('prefix_indexes')->nullable();
            $table->string('schema', 50)->nullable();
            $table->string('sslmode', 20)->nullable();
            $table->string('url')->nullable();

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
        Schema::dropIfExists('data_bases');
    }
}
