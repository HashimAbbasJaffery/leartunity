<div class="course">
    <div class="course-header" style="position: relative;">
        @if($is_purchased)
            <div class="course-pill bg-black text-white px-2 py-1 text-xs" style="border-radius: 10px;position: absolute; right: 10px; top: 10px;">
                <p>Purchased</p>
            </div>
        @endif
        <img src="https://placehold.co/600x400" alt="">
    </div>
    <div class="course-instructor mt-4 flex">
        <div class="instructor-img">
            @if($profile)
                <img src="/profile/{{ $profile }}" height="45" width="45"  class="rounded-full" alt="">
            @else 
                <img src="https://placehold.co/45x45" height="45" width="45"  class="rounded-full" alt="">
            @endif 
        </div>
        <div class="instructor-details flex">
            <h2>{{ $instructor }}</h2>
            <div class="course-rating flex">
                {!! calculateReviewStars($rating) !!}
            </div>
        </div>
    </div>

    <div class="course-detail mt-4">
        <div class="course-description">
            <h1 style="font-size: 15px; font-weight: bold; margin-bottom: 5px;">
                {{ $title }}
            </h1>
            {!! substr($description, 0, 80) !!}...
        </div>
        <div class="course-options mt-2">
            @if(!$is_purchased)
                <a href="{{ route("checkout", ['id' => $stripe ]) }}">enroll</a>
            @else 
                <a href="">Go to Course</a>
            @endif
            <a href="{{ route('course', [ 'course' =>  $slug]) }}">see details</a>
        </div>
        <div class="course-price flex justify-between">
            <p>{{ $price }} $</p>
            <p>{{ $duration }} Hour Course</p>
        </div>
    </div>
</div>
