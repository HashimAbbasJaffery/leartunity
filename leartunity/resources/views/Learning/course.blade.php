<x-layout>
    <div style="border: 1px solid white; background: var(--primary); width: 50%; margin: auto; height: 400px; z-index: 2;" class="animate__animated none comment-post rounded alert-box fixed left-0 right-0 bottom-0 p-2 text-white">
        <div class="comment-post-header flex items-center">
            <i class="fa-solid fa-reply mr-2"></i>
            <p>Replying to Post</p> 
        </div>
        <div class="comment-post-body" style="height: 75%; background: var(--primary);">
            <div class="separator">&nbsp;</div>
            <textarea type="text" id="add-comment" style="resize: none;color: white;background: var(--primary); outline: none;height: 85%;border-radius: 5px; width: 100%; margin-top: 10px;"></textarea>
            <div class="separator">&nbsp;</div>
        </div>
        <div class="comment-post-footer" style="float: right; width: 40%;"> 
            <button class="highlighted cancel-post" style="width: 45%;">Cancel</button>
            <button class="highlighted post-comment" style="width: 45%; background: white; color: black;">Post</button>
        </div>
    </div>
    <section class="mt-3 mb-3 px-1">
        <div class="lecture flex">
            <div class="order-2" style="width: 70%; mrgin-bottom: 10px;">
                <video id="player">
                      <source class="video" src="{{ asset('uploads/' . "dummy.mp4") }}" type="video/mp4" />
                    <source class="video" src="{{ asset('uploads/' . "dummy.mp4") }}" type="video/webm" />
                    <!-- Captions are optional -->
                </video>
                <div class="course-detail">
                    <div class="lecture-detail detail mt-3">
                        Let's get a head start on our new application by using the Blueprint package to generate migrations, model classes (including relationships) and factories.
                    </div> 
                    <div class="instructor-detail detail mt-3 flex">
                        <div class="instructor-pic mr-3">
                            <img src="{{ $course->author->profile->profile_pic ? "/profile/" . $course->author->profile->profile_pic : "https://placehold.co/100x100" }}" jeight="100" width="100" style="border-radius: 50px;"/>
                        </div>
                        <div class="instructor-detail" style="position: relative;">
                            <h1 style="font-weight: bold; font-size: 20px;">{{ $course->author->name }}</h1>
                            <p>I am a TALL stack enthusiast. I have used Laravel to create a SaaS company, and I have 5 kids.</p>
                            <div class="links flex">
                                <a href="#">
                                    <div class="link mr-2" style="color: white;">
                                        <i class="fa-brands fa-github"></i>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="link mr-2" style="color: white">
                                        <i class="fa-brands fa-linkedin"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div> 
                    <div class="additional-links flex mt-2">
                        <a href="#" class="link extra mr-2">Lesson's Code</a>
                        <a href="#" class="link extra">Download Video</a>
                    </div>
                    <div class="additional-links flex mt-2">
                        <button class="link extra mr-2 comment-post-button" style="width: 100%;">Write Comment</button>
                    </div>
                    <div class="comments mt-2">
                        @foreach($comments as $comment)
                            <x-comment-component :isInstructor="$comment->user_id === $course->author_id" :isreply="false" :comment="$comment"/>
                            @forelse($comment->replies as $reply)
                                <x-comment-component :isInstructor="$comment->user_id === $course->author_id" :isreply="true" :comment="$reply"/>
                            @empty 
                            @endforelse
                        @endforeach
                    </div> 
                </div>
            </div>
            <div class="lectures order-1 mr-2" style="width: 30%">
                <div class="sections mb-2">
                    @foreach($course->sections as $section)
                        <x-section-component :id="$loop->index" :name="$section->section_name" />
                        @if($section->contents)
                            <x-lessons-component :id="$loop->index" :lessons="$section->contents" />
                        @endif 
                    @endforeach
                </div>
            </div>
        </div>
        <p></p>
    </section>
    @push("scripts")
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
          
    <script>
        const player = new Plyr("#player");
        player.source = {
            type: 'video',
            title: 'Example title',
            sources: [
                {
                    src: '/uploads/dummy.mp4',
                    type: 'video/mp4',
                } 
            ],
        }
    </script>
    <script>
        const sections = document.querySelectorAll(".section");
        sections.forEach(section => {
            section.addEventListener("click", function() {
                const id = section.dataset.lectureid;
                const element = document.getElementById(id);
                element.classList.toggle("none");
            })    
        })
    </script>
    <script>
        const btn = document.querySelector(".comment-post-button");
        const cancelBtn = document.querySelector(".cancel-post");
        btn.addEventListener("click", function() {
            const post = document.querySelector(".comment-post");
            post.classList.remove("none")
            post.classList.remove("animate__backOutDown")
            post.classList.add("animate__backInUp")
            
        })
        cancelBtn.addEventListener("click", function() {
            const post = document.querySelector(".comment-post");
            
            post.classList.add("animate__backOutDown")
            
            post.classList.remove("animate__backInUp")
        })
    </script>
    <script>
        const post = document.querySelector(".post-comment");
        post.addEventListener("click", function() {
            const comment = document.getElementById("add-comment");
            axios.post("{{ route('create.comment', ['course' => $course->slug]) }}", {
                comment: comment.value
            })
            .then(res => {
                if(res.data === 1) {
                    location.reload();
                }
            })
            .catch(err => {
                console.log(err)
            })
        })
    </script>
    @endpush
</x-layout>