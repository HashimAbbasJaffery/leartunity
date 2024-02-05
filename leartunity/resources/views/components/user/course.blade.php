<div class="course">
    <div class="course-header">
        <img src="https://placehold.co/600x400" alt="">
    </div>
    <div class="course-instructor mt-4 flex">
        <div class="instructor-img">
            <img src="https://placehold.co/45x45" class="rounded-full" alt="">
        </div>
        <div class="instructor-details flex">
            <h2>{{ $instructor }}</h2>
            @php 
                $total = 5;
                $stars = floor($rating); // 1
                $halfStar = $rating - $stars; // 1.4 - 1 = 0.4
                $remainingStars = ($total - $stars);
                if($halfStar >= 0.5) {
                    $remainingStars -= $halfStar;
                }
                $remainingStars = floor($remainingStars);
            @endphp 
            <div class="course-rating flex">
                @if($rating <= 5 && $rating != 0)
                    @for($i = 0; $i < $stars; $i++)
                        <i class="fa-solid fa-star"></i>
                    @endfor
                    @if($halfStar >= 0.5)    
                        <i class="fa-solid fa-star-half-stroke"></i>
                    @endif
                    @for($i = 0; $i < ($remainingStars); $i++)
                        <i class="fa-regular fa-star"></i>
                    @endfor
                @else 
                    <p>No rating yet!</p>
                @endif 
            </div>
        </div>
    </div>

    <div class="course-detail mt-4">
        <div class="course-description">
            <h1 style="font-size: 15px;">
                {{ $title }}
            </h1>
            {!! substr($description, 0, 80) !!}...
        </div>
        <div class="course-options mt-2">
            <a href="#">enroll</a>
            <a href="#">see details</a>
        </div>
        <div class="course-price flex justify-between">
            <p>{{ $price }} $</p>
            <p>{{ $duration }} Hour Course</p>
        </div>
    </div>
</div>
