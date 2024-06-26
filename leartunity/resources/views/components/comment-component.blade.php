<div class="comment p-4 {{ $isreply ? 'reply' : '' }}" style="border-radius: 10px;">
    <div class="comment-content flex">
        <div class="comment-header mr-2">
            <img src="{{ $comment->user->profile?->profile_pic ? "/profile/" . $comment->user->profile?->profile_pic : 'https://placehold.co/90x90' }}" height="90" width="90" style="border-radius: 10px;"/>
            <p class="text-center mt-2" style="font-size: 9px;">Posted {{ $comment->created_at->diffForHumans() }}</p>
        </div>
        <div class="comment-body">
                <h1 style="font-weight: 500;" class="mb-2 flex">
                    {{ $comment->user->name }}
                    @php 
                        $isInstructor = $comment->user_id === $comment->course->author_id;
                    @endphp 
                    @if($isInstructor)
                        <div class="pill ml-3 px-2 py-1 rounded-full flex justify-center items-center" style="font-size: 10px;background: #01B9F9;">Instructor</div>
                    @endif
                </h1>
            <div class="content-material">
                <p>
                {!! $comment->comment !!}
                </p>
            </div>
            <button class="comment-reply" data-user="{{ $comment->user_id }}" data-id="{{ $comment->id }}" data-name="{{ $comment->user->name }}">Reply</button>
        </div>
    </div>
</div>
@if($isreply)
    @php 
        $reply = $comment;
    @endphp
    @forelse($reply->replies as $reply)
        <x-comment-component :isreply="true" :comment="$reply"/>
    @empty 

    @endforelse
@endif
