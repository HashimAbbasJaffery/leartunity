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

        // Checking if that is already awarded or not 
        $is_awarded = $following->achievements()->where("user_id", $following->id)->whereIn("achievement_id", $achievementable_ids)->exists();
        if($is_awarded) return;

        // If everything works the award the badge!
        $following->achievements()->attach($achievementable_ids);

        NotificationEvent::dispatch($following->id, "You have been awarded Badge!");
        
    }
}
