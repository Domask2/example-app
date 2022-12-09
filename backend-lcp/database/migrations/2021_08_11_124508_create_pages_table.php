<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//{"id": 0, "title": "Страницы", "key": "k01", "page": "0", "children": [{"id": 1, "title": "Admin", "page": "admin", "key": "k01-admin", "children": []}, {"id": 2, "title": "Главная", "page": "general", "key": "k01-general", "children": []}, {"id": 3, "title": "Таблица", "page": "table", "key": "k01-table", "children": []}]}

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title', 50);
            $table->string('key', 50)->index();
            $table->string('description')->nullable();
            $table->unique(['project_id', 'key']);
            $table->jsonb('components');

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
        Schema::dropIfExists('pages');
    }
}
