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
    public function __construct(Content $content)
    {
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.lesson-component');
    }
}
