<?php

namespace App\Observers;
use App\Events\NotificationEvent;
use App\Models\Comment;
use App\Notifications\MessageNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;

class CommentObserver
{
    public function retrieved(Comment $comment) {
        $pattern = '/@([^\s]+(?:\.\w+)?)/';
        $replies_to = $comment->replies_to;
        $editedComment = preg_replace($pattern, "<a href='/profile/$replies_to' class='tagging-to'>$0</a>", $comment->comment);
        $comment->comment = $editedComment;
    }
    public function created(Comment $comment) {
        
        $to = $comment?->to;
        $replying = $comment->user;
        $message = $comment->comment;
        if($to) {
            $user = \App\Models\User::find($to);
            NotificationEvent::dispatch($to, "$replying->name: $message");
            $user->notify(new MessageNotification("$replying->name: $message")); 
        }
    }
}
