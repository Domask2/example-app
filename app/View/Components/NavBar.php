<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavBar extends Component
{
    public $appName;

    /**
     * Create a new component instance.
     *
     * @param $appName
     */
    public function __construct($appName)
    {
        $this->appName = $appName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav-bar');
    }
}
