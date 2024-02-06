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
            <div class="course-rating flex">
                {!! calculateReviewStars($rating) !!}
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
