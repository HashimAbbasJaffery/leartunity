<div class="course">
    <div class="course-header" style="position: relative;">
        @php
            $author = $course->author->id ?? "null";
        @endphp
        @if($author === auth()->id())
            <label class="switch" style="position: absolute; left: 13px; top: 10px;">
                <input type="checkbox" @checked($course->status) class="course-switch" id="course-{{ $course->id }}">
                <span class="slider round"></span>
            </label>
        @endif
        <div style="position: absolute; bottom: 10px; right: 10px;" class="flex">
            <form class="mr-2" action="{{ route("course.delete", [ 'course' => $course->slug ?? 'nnull']) }}" method="POST" name="courseDelete" id="courseDelete">
                {{ method_field("DELETE") }}
                @csrf
                <button class="text-white px-2 rounded bg-red-500 hover:bg-red-600">Delete</button>
            </form>
            <form action="{{ route("course.edit", [ 'course' => $course->slug ?? 'null' ]) }}" name="courseDelete" id="courseDelete">
                @csrf
                <button class="text-white px-2 rounded bg-blue-500 hover:bg-blue-600">Update</button>
            </form>
        </div>
        @if($is_purchased)
            <div class="course-pill bg-black text-white px-2 py-1 text-xs" style="position: absolute; right: 10px; top: 10px; border-radius: 10px;">
                <p>Purchased</p>
            </div>
        @endif
        @if($course->thumbnail)
            <img src="/course/{{ $course->thumbnail }}" style="border-radius: 10px;" height="600" width="400" alt="">
        @else 
            <img src="https://placehold.co/600x400" height="600" width="400" alt="">
        @endif 
    </div>
    <div class="course-instructor mt-4 flex">
        <div class="instructor-img">
            @if($course->author?->profile)
                <img src="/profile/{{ $course->author->profile->profile_pic }}" height="45" width="45"  class="rounded-full" alt="">
            @else 
                <img src="https://placehold.co/45x45" height="45" width="45"  class="rounded-full" alt="">
            @endif 
        </div>
        <div class="instructor-details flex">
            <h2>{{ $course->author?->name }}</h2>
            <div class="course-rating flex">
                {!! calculateReviewStars($course->reviews?->stars) !!}
            </div>
        </div>
    </div>

    <div class="course-detail mt-4">
        <div class="course-description">
            <h1 style="font-size: 15px; font-weight: bold; margin-bottom: 5px;">
                {{ $course->title }}
            </h1>
            {!! substr($course->description, 0, 80) !!}...
        </div>
        <div class="course-options mt-2">
            @if(!$is_purchased)
                <a href="{{ route("checkout", ['id' => $course->stripe_id ?? 'null' ]) }}">enroll</a>
            @else 
                <a href="">Go to Course</a>
            @endif
            <a href="{{ route('course', [ 'course' =>  $course->slug ?? 'null']) }}">see details</a>
            
            @if($author === auth()->id())
                <a href="{{ route('course.show', ["course" => $course->slug ?? 'null']) }}">Manage</a>
            @endif
        </div>
        <div class="course-price flex justify-between">
            <p>{{ $course->price }} $</p>
            <p>Duration: {{ secondsToHours($course->contents_sum_duration) }}</p>
        </div>
    </div>
</div>
