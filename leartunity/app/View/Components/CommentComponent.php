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
    public function __construct(Comment $comment, $isreply)
    {
        $this->comment = $comment;
        $this->isreply = $isreply;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comment-component');
    }
}
