<div class="lessons none" id="{{ $id }}">
    @foreach($lessons as $lesson)
        <x-lesson-component :content="$lesson" />
    @endforeach
</div>