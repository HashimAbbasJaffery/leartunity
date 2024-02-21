<?php

namespace App\View\Components\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Course extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $instructor;
    public $duration;
    public $price;
    public $rating;
    public $description;
    public $stripe;
    public $slug;
    public $profile;
    public $thumbnail;
    public function __construct(
        $title, 
        $instructor, 
        $price, 
        $rating, 
        $duration,
        $description,
        $stripe,
        $slug,
        $profile,
        $thumbnail
    )
    {
        $this->title = $title;
        $this->instructor = $instructor;
        $this->price = $price;
        $this->rating = $rating;
        $this->duration = $duration;
        $this->description = $description;
        $this->stripe = $stripe;
        $this->slug = $slug;
        $this->profile = $profile;
        $this->thumbnail = $thumbnail;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = auth()->user();
        $purchases = $user?->purchases()->where("purchase_product_id", $this->stripe)->first();
        $is_purchased = false;
        if($purchases) {
            $is_purchased = true;
        }
        return view('components.user.course', compact("is_purchased"));
    }
}
