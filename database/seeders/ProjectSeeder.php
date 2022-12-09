<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nav1 = [
            [
                'title' => 'Главный раздел',
                'key' => 'gen_part',
                'page' => 'gen_part'
            ],
            [
                'title' => 'Второй раздел',
                'key' => 'second_part',
                'page' => null,
                'children' => [
                    [
                        'title' => 'Пользователи страница',
                        'key' => 'users_page',
                        'page' => 'users_page'
                    ],
                    [
                        'title' => 'Сообщения',
                        'key' => 'message_page',
                        'page' => 'message_page'
                    ],
                ]
            ]
        ];
        $nav2 = [
            [
                'title' => 'Основной раздел',
                'key' => 'gen_part',
                'page' => null,
                'children' => [
                    [
                        'title' => 'Страница !',
                        'key' => 'gen_page',
                        'page' => 'gen_page'
                    ],
                    [
                        'title' => 'Страница 2',
                        'key' => 'about_page',
                        'page' => 'about_page'
                    ],
                ]
            ],
            [
                'title' => 'Второстепенный раздел',
                'key' => 'second_part',
                'page' => null,
                'children' => [
                    [
                        'title' => 'Страница 11',
                        'key' => 'users_page',
                        'page' => 'users_page'
                    ],
                    [
                        'title' => 'Страница 12',
                        'key' => 'message_page',
                        'page' => 'message_page'
                    ],
                ]
            ]
        ];

        Project::create([
            'user_id' => 1,
            'title' => 'Первый проект',
            'key' => 'first_project',
            'description' => 'Описание первого проекта.',
            'is_published' => true,
            'navigation' => json_encode($nav1)
        ]);

        Project::create([
            'user_id' => 1,
            'title' => 'Второй проект',
            'key' => 'second_project',
            'description' => 'Описание второго проекта.',
            'is_published' => false,
            'navigation' => json_encode($nav2)
        ]);
    }
}
