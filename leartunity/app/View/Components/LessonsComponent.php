<?php

namespace App\View\Components;

use App\Models\Content;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LessonsComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $lessons;
    public $id;
    public function __construct($lessons, $id)
    {
        $this->lessons = $lessons;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.lessons-component');
    }
}
