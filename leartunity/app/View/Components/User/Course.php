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
    public function __construct(
        $title, 
        $instructor, 
        $price, 
        $rating, 
        $duration,
        $description
    )
    {
        $this->title = $title;
        $this->instructor = $instructor;
        $this->price = $price;
        $this->rating = $rating;
        $this->duration = $duration;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.course');
    }
}
