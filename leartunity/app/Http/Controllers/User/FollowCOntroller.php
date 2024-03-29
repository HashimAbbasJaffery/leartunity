<?php

namespace App\Http\Controllers\User;

use App\Events\FollowerCounter;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Notifications\MessageNotification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

class FollowCOntroller extends Controller
{
    public function store(Profile $profile) {
        $follower_id = auth()->user(); // The one who is following
        $followee_id = $profile->user->id;
        $is_following = $profile->user->follows()->where("follower_id", $follower_id->id)->exists();
        $status = 0;
        if(!$is_following) {
            $followingSelf = auth()->user()->id != $followee_id;

            if($followingSelf) {
                NotificationEvent::dispatch($profile->user->id, $follower_id->name . " started following you");
                $profile->user->notify(new MessageNotification($follower_id->name . " started following you"));
            }
            $follower_id->follows_to()->attach($followee_id);
        } else {
            $follower_id->follows_to()->detach($followee_id);
            $status = 1;
        }
        $followersCount = $profile->user->follows->count();
        FollowerCounter::dispatch($followersCount, $profile->user);




        return $this->response("$status", "$followersCount");
    }
}
