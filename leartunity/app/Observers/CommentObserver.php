<?php

namespace App\Observers;
use App\Models\Comment;

class CommentObserver
{
    public function retrieved(Comment $comment) {
        $pattern = '/@([^\s]+(?:\.\w+)?)/';
        $replies_to = $comment->replies_to;
        $editedComment = preg_replace($pattern, "<a href='/profile/$replies_to' class='tagging-to'>$0</a>", $comment->comment);
        $comment->comment = $editedComment;
    }
}
