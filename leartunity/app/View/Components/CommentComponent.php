<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Comment;

class CommentComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public Comment $comment;
    public $isreply;
    public $isInstructor;
    public function __construct(Comment $comment, $isreply, $isInstructor)
    {
        $this->comment = $comment;
        $this->isreply = $isreply;
        $this->isInstructor = $isInstructor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comment-component');
    }
}
