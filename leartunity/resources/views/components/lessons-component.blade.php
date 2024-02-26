<div class="lessons none" id="{{ $id }}">
    @foreach($lessons as $lesson)
        <x-lesson-component :watched="in_array($lesson->id, $tracker)" :content="$lesson" />
    @endforeach
</div>