<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Layout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = User::find(auth()->user()?->id);
        $notifications = $user?->unreadNotifications() ?? 0;
        $currencies = DB::table("currencies")->get();
        return view('components.layout', compact("notifications", "user", "currencies"));
    }
}
