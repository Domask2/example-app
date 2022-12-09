<?php

namespace App\View\Components;

use App\Models\DataBase;
use App\Models\Project;
use Illuminate\View\Component;

class HeadMenu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (auth()->user()) {
            $columns = ['id' , 'key' , 'title', 'user_id'];
            $databases = DataBase::get($columns)->where('user.id', auth()->user()->id);
        } else {
            $databases = [];
        }
        return view('components.head-menu', compact(['databases']));
    }
}
