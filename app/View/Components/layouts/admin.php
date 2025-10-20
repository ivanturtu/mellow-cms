<?php

namespace App\View\Components\layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class admin extends Component
{
    public $title;

    /**
     * Create a new component instance.
     */
    public function __construct($title = 'Admin')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.admin');
    }
}

