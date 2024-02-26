<a href="{{ route('watch.course', [ 'course' => request()->route('course'), 'content' => $content->id ]) }}">
    <div class="lesson mb-3">
    <div class="lesson flex rounded lesson-body" 
        @if(request()->route("content")->id == $content->id)
            style="background: rgb(234, 234, 234); padding: 10px;"
        @endif
    >
        <div class="play-video mr-3 flex align-items justify-center">
            @if($watched)
                <i class="fa-solid fa-check"></i>
            @else 
                @if(request()->route("content")->id == $content->id)
                    <i class="fa-solid fa-pause"></i>
                @else
                    <i class="fa-solid fa-play"></i>
                @endif
            @endif
        </div>
        <div class="details">
            <h2 style="font-size: 14px;">{{ $content->title }}</h1>
            <p style="font-size: 12px;">
                <i class="fa-solid fa-clock mr-1"></i>
                1:00
            </p>
        </div>
    </div>
</div>
</a>