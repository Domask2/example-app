<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->index();
            $table->string('user_id', 300);

            $table->string('file', 100);
            $table->string('title', 100)->nullable();
            $table->string('description', 300)->nullable();

            $table->string('url', 300);
            $table->string('project', 100)->nullable();
            $table->string('project_page', 100)->nullable();
            $table->boolean('visible')->default(true);

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
        Schema::dropIfExists('downloads');
    }
}
