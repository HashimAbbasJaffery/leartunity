<?php

namespace App\Listeners;

use App\Events\FollowerCounter;
use App\Events\NotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Achievement;
use Illuminate\Support\Facades\Log;

class FollowerListener
{
    /**
     * Create the event listener.
     */
    public $type;
    public function __construct()
    {
        $this->type = "followers";
    }

    /**
     * Handle the event.
     */
    public function handle(FollowerCounter $followerCounter): void
    {
        $following = $followerCounter->following;
        $counts = $followerCounter->counts;
        $achievementables = Achievement::with("achievements")->achieveables([ "type" => $this->type, "quantity" => $counts ])->get();
        $achievementable_ids = $achievementables->pluck("id")->toArray();

        // Achievements of the user
        $achievements = $following->achievements->pluck("id")->toArray();

        /* Filtering the both arrays like A - B set to know which achievement 
        is not granted yet! */  
        $achievements = array_diff($achievementable_ids, $achievements);

        // If everything works the award the badge!
        $following->achievements()->attach($achievements);

        if(count($achievements) > 0)
            NotificationEvent::dispatch($following->id, "You have been awarded Badge!");
        
    }
}
