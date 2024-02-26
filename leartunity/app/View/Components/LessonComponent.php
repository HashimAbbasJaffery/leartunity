<?php

namespace App\View\Components;

use App\Models\Content;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LessonComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public Content $content;
    public $current;
    public $watched;
    public function __construct(Content $content, Content $current, $watched)
    {
        $this->content = $content;
        $this->current = $current;
        $this->watched = $watched;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.lesson-component');
    }
}
