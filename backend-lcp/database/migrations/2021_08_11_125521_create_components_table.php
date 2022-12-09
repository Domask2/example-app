<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();

            $table->string('part', 50);
            $table->string('key', 50);
            $table->string('type', 50);

            /** props - будет прокидываться в компоненте как props */
            $table->jsonb('props')->nullable();
            /** styles - будет передаваться компоненте в style */
            $table->jsonb('style')->nullable();
            /** styles - настройки компоненты не попадающие в props (caption, ...) */
            $table->jsonb('sett')->nullable();

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
        Schema::dropIfExists('components');
    }
}
