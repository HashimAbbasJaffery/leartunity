<?php

namespace App\View\Components\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Course as CourseInstance;

class Course extends Component
{
    /**
     * Create a new component instance.
     */
    // public $title;
    // public $instructor;
    // public $duration;
    // public $price;
    // public $rating;
    // public $description;
    // public $stripe;
    // public $slug;
    // public $profile;
    // public $thumbnail;
    // public $status;

    public CourseInstance $course;
    public function __construct(
        CourseInstance $course,
    )
    {
        $this->course = $course;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = auth()->user();
        $purchases = $user?->purchases()->where("purchase_product_id", $this->course->stripe_id)->first();
        $is_purchased = false;
        if($purchases) {
            $is_purchased = true;
        }
        return view('components.user.course', compact("is_purchased"));
    }
}
