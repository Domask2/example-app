<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $components = json_encode([["id" => 1, "key" => "0", "type" => "Row", "props" => ["gutter" => [16, 16]], "children" => [["id" => 3, "key" => "g0-0", "type" => "Col", "props" => ["span" => 6], "children" => [["id" => 2, "key" => "g0-0-0", "type" => "Card", "props" => ["size" => "small", "title" => "Заголовок №1"], "children" => [["id" => 21, "key" => "g0-0-0-0", "type" => "Button", "props" => ["type" => "primary", "className" => "p-button-sm"], "caption" => "b-101"], ["id" => 22, "key" => "g0-0-0-1", "type" => "Button", "props" => ["type" => "default", "className" => "p-button-sm"], "caption" => "b-102"], ["ds" => ["key" => "flags-1", "item_key" => "check1"], "id" => 547, "key" => "g0-0-0-2", "type" => "Checkbox", "props" => [], "caption" => "Еще один чекбокс"]]]]], ["id" => 5543, "key" => "g0-1", "type" => "Col", "props" => ["span" => 18], "children" => [["id" => 3, "key" => "g0-1-0", "sett" => ["visible" => ["ds_key" => "flags-1", "ds_item_key" => "check1"]], "type" => "Card", "props" => ["size" => "small", "title" => "Заголовок №2"], "children" => [["id" => 557, "key" => "g0-1-0-0", "type" => "Row", "props" => ["gutter" => [16, 16]], "children" => [["id" => 558, "key" => "g0-1-0-0-0", "type" => "Col", "props" => ["span" => 24], "children" => [["ds" => ["key" => "flags-1", "item_key" => "check2"], "id" => 559, "key" => "g0-1-0-0-0-0", "type" => "Checkbox", "props" => [], "caption" => "Чекбокс - 2"]]]]], ["id" => 560, "key" => "g0-1-0-1", "type" => "Divider"], ["id" => 570, "key" => "g0-1-0-2", "type" => "Row", "props" => ["gutter" => [16, 16]], "children" => [["id" => 580, "key" => "g0-1-0-2-0", "type" => "Col", "props" => ["span" => 24], "children" => [["id" => 30, "key" => "g0-1-0-2-0-0", "type" => "Button", "props" => ["type" => "primary"], "caption" => "primary"], ["id" => 300, "key" => "g0-1-0-2-0-1", "type" => "Button", "props" => ["type" => "default"], "caption" => "default"], ["id" => 301, "key" => "g0-1-0-2-0-2", "type" => "Button", "props" => ["type" => "dashed"], "caption" => "dashed"], ["id" => 32, "key" => "g0-1-0-2-0-3", "type" => "Button", "props" => ["type" => "text"], "caption" => "text"], ["id" => 33, "key" => "g0-1-0-2-0-4", "type" => "Button", "props" => ["type" => "link"], "caption" => "link"], ["id" => 33123, "key" => "g0-1-0-2-0-5", "type" => "Divider"], ["id" => 3011, "key" => "g0-1-0-2-0-6", "type" => "Button", "props" => ["type" => "primary", "danger" => true], "caption" => "primary"], ["id" => 30011, "key" => "g0-1-0-2-0-7", "type" => "Button", "props" => ["type" => "default", "danger" => true], "caption" => "default"], ["id" => 30111, "key" => "g0-1-0-2-0-8", "type" => "Button", "props" => ["type" => "dashed", "danger" => true], "caption" => "dashed"], ["id" => 3211, "key" => "g0-1-0-2-0-9", "type" => "Button", "props" => ["type" => "text", "danger" => true], "caption" => "text"], ["id" => 3311, "key" => "g0-1-0-2-0-20", "type" => "Button", "props" => ["type" => "link", "danger" => true], "caption" => "link"]]]]]]]]]]], ["id" => 121, "key" => "g1", "type" => "Divider"], ["id" => 224, "key" => "g2", "type" => "Row", "props" => ["gutter" => [16, 16]], "children" => [["id" => 334, "key" => "g2-0", "type" => "Col", "props" => ["span" => 6], "children" => [["id" => 335, "key" => "g2-0-0", "type" => "Card", "props" => ["size" => "small", "title" => "Список чекбоксов"], "children" => [["ds" => ["key" => "animals"], "id" => 336, "key" => "g2-0-0-0", "item" => ["caption" => "klichka"], "type" => "CheckboxGroup", "props" => []], ["id" => 337, "key" => "g2-0-0-1", "type" => "Divider"]]]]], ["id" => 338, "key" => "g2-1", "type" => "Col", "props" => ["span" => 18], "children" => [["id" => 339, "key" => "g2-2", "type" => "Card", "props" => ["size" => "small", "title" => "Таблица животных"], "children" => [["ds" => ["key" => "animals"], "id" => 340, "key" => "g2-2-0", "type" => "Table", "props" => ["size" => "small"]]]]]]]]]);

        Page::create([
            'project_id' => 1,
            'title' => 'Первая страница',
            'key' => '/first_project/gen_part',
            'description' => 'Описание первой страницы.',
            'components' => $components
        ]);

    }
}
