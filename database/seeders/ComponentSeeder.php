<?php

namespace Database\Seeders;

use App\Models\Component;
use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $component = [
            'part'  => 'grid',
            'key'   => 'row',
            'type'  => 'row',
            'props' => json_encode([]),
            'style' => json_encode([]),
            'sett'  => json_encode([])
        ];
        Component::create($component);
        $component = [
            'part'  => 'grid',
            'key'   => 'col',
            'type'  => 'col',
            'props' => json_encode([]),
            'style' => json_encode([]),
            'sett'  => json_encode([])
        ];
        Component::create($component);
        $component = [
            'part'  => 'data',
            'key'   => 'table',
            'type'  => 'table',
            'props' => json_encode([]),
            'style' => json_encode([]),
            'sett'  => json_encode([])
        ];
        Component::create($component);
        $component = [
            'part'  => 'data',
            'key'   => 'checkbox',
            'type'  => 'checkbox',
            'props' => json_encode([]),
            'style' => json_encode([]),
            'sett'  => json_encode([])
        ];
        Component::create($component);
        $component = [
            'part'  => 'data',
            'key'   => 'radio',
            'type'  => 'radio',
            'props' => json_encode([]),
            'style' => json_encode([]),
            'sett'  => json_encode([])
        ];
        Component::create($component);
        $component = [
            'part'  => 'action',
            'key'   => 'button',
            'type'  => 'button',
            'props' => json_encode([]),
            'style' => json_encode([]),
            'sett'  => json_encode([])
        ];
        Component::create($component);
    }
}
