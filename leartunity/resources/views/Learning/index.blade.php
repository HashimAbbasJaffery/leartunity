<x-layout>
    <section id="purchased-courses" class="container mx-auto mt-10">
        @forelse($purchases as $purchase)
            <div class="course flex" style="position: relative;">
                <div class="course-image mr-5" style="width: 20%">
                    <img src="{{ ( $purchase->course->thumbnail )? "/course/" . $purchase->course->thumbnail : 'https://placehold.co/600x400' }}" height="250" width="250" class="rounded" />
                </div>
                <div class="course-detail" style="width: 80%">
                    <h1 class="text-xl mb-2" style="font-weight: 600;">{{ $purchase->course->title }}</h1>
                    <p>{{ substr(str_replace("</p>", "", str_replace("<p>", "", $purchase->course->description)),0, 180) }}...</p>
                    <a href="/profile/{{ $purchase->course->author->id }}" style="font-size: 13px;" class="mt-2 mb-2">{{ $purchase->course->author->name }}</a>
                    <div class="progress mt-2">
                        @php 
                            $progress = $purchase->course->tracker->progress;
                        @endphp
                        <p style="font-size: 13px; float: right;">{{ $progress }}%</p>
                        <div class="progress-bar" style="background: rgb(222, 222, 222); height: 2px;">
                            <div class="completed-progress" style="background: var(--primary); height: 2px; width: {{ $progress }}%;">&nbsp;</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('watch.course', ['course' => $purchase->course->slug, 'content' => '1']) }}" style="text-align:center; width: 10%;padding: 3px 6px 3px 6px;position: absolute; right: 0px;" class="highlighted">Resume</a>
            </div>
        @empty 
            <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>Oops! No course foumd! Time to grab your learning cap and join the fun by purchasing <a style="text-decoration: underline;" href="/courses">Courses</a>! 🎓😄</p>
            </div>
        @endforelse
    </section>
</x-layout>