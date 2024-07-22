
<x-layout>
    <div class="progress {{ $course->tracker->progress >= 100 ? '' : 'none'}} container mx-auto download-certificate py-3 px-2 rounded" style="bottom: 10px; left: 10px;background: #15F5BA; position: fixed; width: 50%; z-index: 2">
        You Have completed this course! Download your certificate from <a href="/learn/certificate/{{ $course->id }}" style="text-decoration: underline;">Here</a>
    </div>
    <div style="border: 1px solid white; background: var(--primary); width: 50%; margin: auto; height: 400px; z-index: 2;" class="animate__animated none comment-post rounded alert-box fixed left-0 right-0 bottom-0 p-2 text-white">
        <div class="comment-post-header flex items-center">
            <i class="fa-solid fa-reply mr-2"></i>
            <p>Replying to <span class="replying_to">Post</span></p> 
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
                @if($current_content->content_type == 1)
                    <video id="player">
                        <source class="video" src="{{ asset('uploads/' . "dummy.mp4") }}" type="video/mp4" />
                        <source class="video" src="{{ asset('uploads/' . "dummy.mp4") }}" type="video/webm" />
                        <!-- Captions are optional -->
                    </video>
                @else
                    <div class="description">
                        @php  
                            $questions = json_decode($current_content->content);
                        @endphp 
                        @if(session()->has("quiz") && (session()->get("quiz")[0] === 1))
                            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <span class="font-medium">That's fantastic! Your score of {{ session()->get("quiz")[1] }}% on the quiz shows you've mastered the material. 
                            </div>
                        @elseif(session()->has("quiz") && (session()->get("quiz")[0] !== 1))
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">{{ session()->get("quiz")[1] }}% isn't the end! Keep practicing, you've got this!
                            </div>
                        @endif 
                        @if(isset($instance_tracker) && !count((array)$instance_tracker) && $instance_tracker->status === "completed")
                            @unless(session()->has("quiz") && (session()->get("quiz")[0] === 1))
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">You need to score {{ ((array)$questions)["min-score"] }}% in order to be eligible for certification...
                                </div>
                            @endunless
                        @else 
                            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <span class="font-medium">You have Passed the Exam with score of {{ $quiz_tracker->score }}%
                            </div>
                        @endif
                    </div>
                    <div class="questions">
                        <form method="POST"  name="submitQuiz" style="display: inline-block;" id="submitQuiz" action="{{ route("quiz.submit", [ 'content' => $current_content ]) }}">
                        @csrf    
                        @foreach($questions as $key => $question)   
                                @if($key == "min-score") @break @endif

                                <h1 class="text-xl font-bold mb-2">Question No. {{ $loop->iteration }}</h1>

                                @if($question->isBoolean)
                                    <div class="question mb-8">
                                        <p>{{ $question->question }}</p>
                                        <ul class="mt-3">
                                            <li><input class="mr-2" type="radio" name="{{ $key }}" value="1">True</li>
                                            <li><input class="mr-2" type="radio" name="{{ $key }}" value="0">False</li>
                                        </ul>
                                    </div>
                                @else 

                                    <div class="question mb-8">
                                        
                                        <p>{{ $question->question }} {{ (array_count_values($question->keys)["on"] > 1) ? "Select All that apply" : ""}}</p>
                                        <ul class="mt-3">
                                            @foreach($question->options as $option)
                                                
                                                <li><input class="mr-2" value="{{ $loop->index }}" type="{{ App\Helpers\is_radio_option(array_count_values($question->keys)["on"], 'radio', 'checkbox') }}" name="{{ $key . App\Helpers\is_radio_option(array_count_values($question->keys)["on"], '', "_$loop->index")}}">{{ $option }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif 
                                @endforeach 
                                <input type="submit" value="Submit" style="border-radius: 0px; width: 20%; cursor: pointer;">
                            </form>
                        
                    </div>
                @endif
                <div class="course-detail">
                    <div class="lecture-detail detail mt-3">
                        {{ $current_content->description }}
                    </div> 
                    <div class="instructor-detail detail mt-3 flex">
                        <div class="instructor-pic mr-3">
                            <img src="{{ $course->author->profile?->profile_pic ? "/profile/" . $course->author->profile->profile_pic : "https://placehold.co/100x100" }}" jeight="100" width="100" style="border-radius: 50px;"/>
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
                            <x-comment-component :isreply="false" :comment="$comment"/>
                            @forelse($comment->replies as $reply)
                                <x-comment-component :isreply="true" :comment="$reply"/>
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
                        @php 
                            $contents = $section->contents()->orderBy("sequence", "asc")->get();
                        @endphp 
                        @if($contents)
                            <x-lessons-component :tracker="$tracker" :id="$loop->index" :lessons="$contents" />
                        @endif 
                    @endforeach
                </div>
            </div>
        </div>
        <input type="hidden" id="replying_to">
        <input type="hidden" id="replies_to" />
        <p></p>
    </section>
    @push("scripts")
    <script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>
    @if(session()->has("quiz") && (session()->get("quiz")[0] === 1))
    <script>
        const count = 200,
  defaults = {
    origin: { y: 0.7 },
  };

function fire(particleRatio, opts) {
        confetti(
            Object.assign({}, defaults, opts, {
            particleCount: Math.floor(count * particleRatio),
            })
        );
        }

        fire(0.25, {
        spread: 26,
        startVelocity: 55,
        });

        fire(0.2, {
        spread: 60,
        });

        fire(0.35, {
        spread: 100,
        decay: 0.91,
        scalar: 0.8,
        });

        fire(0.1, {
        spread: 120,
        startVelocity: 25,
        decay: 0.92,
        scalar: 1.2,
        });

        fire(0.1, {
        spread: 120,
        startVelocity: 45,
        });
    </script>
    @endif
    <script>
    </script>
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script>
        const replying_to = replying_to => {
            const comment = document.getElementById("add-comment");
            const replying = document.querySelector(".replying_to");
            replying.textContent = replying_to;
            comment.value = `@${replying_to.replaceAll(" ", "-")}`
        }
    </script>   
    <script>
        const player = new Plyr("#player");
        player.source = {
            type: 'video',
            title: 'Example title',
            sources: [
                {
                    src: '/uploads/{{ $current_content->content }}',
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
            const replies = document.getElementById("replies_to");
            replies.value = "";
            const post = document.querySelector(".comment-post");
            replying_to("Post");
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
        const postComment = (userComment, replies_to) => {
            const to = document.getElementById("replying_to");
            axios.post("{{ route('create.comment', ['course' => $course->slug, 'content' => $current_content->id]) }}", {
                comment: userComment,
                replies_to: replies_to,
                ...(to.value && { replying_to: to.value })
            })
            .then(res => {
                console.log(res);
                if(res.data === 1) {
                    location.reload();
                }
            })
            .catch(err => {
                console.log(err)
            })
        }
        const post = document.querySelector(".post-comment");
        const commentModal = document.querySelector(".comment-post")
        const replies = document.querySelectorAll(".comment-reply");
        post.addEventListener("click", function() {
            
            const replies = document.getElementById("replies_to");
            const comment = document.getElementById("add-comment");
            postComment(comment.value, replies.value);
        })
        replies.forEach(reply => {
            reply.addEventListener("click", function() {
                const comment = document.getElementById("add-comment");
                const replies = document.getElementById("replies_to");
               
                const replies_to = reply.dataset.id;
                const name = reply.dataset.name;
                replying_to(name);
                const replying = document.getElementById("replying_to");
                replying.value = reply.dataset.user;

                replies.value = replies_to;
                commentModal.classList.remove("none")
                commentModal.classList.remove("animate__backOutDown")
                commentModal.classList.add("animate__backInUp")
            })
        })
    </script>
    <script>
        const plyr = document.querySelector(".plyr");
        plyr.addEventListener("ended", function() {
            
            axios.post("{{ route('update.tracker', ['content' => $current_content, 'course' => $course]) }}")
                .then(res => {
                    console.log(res);
                    const progress = res.data;
                    const progressDiv = document.querySelector(".progress");
                    if(progress >= 100){
                        progressDiv.classList.remove("none");
                    }
                })
                .catch(err => {
                    console.log(err);
                })
            
            
            @if($next_content)
            Swal.fire({
                title: "Do you want to see next tutorial?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: `No`
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = "{{ route('watch.course', ['course' => $course->slug, 'content' => $next_content->id]) }}"
            
                } else if (result.isDenied) {

                }
                });
            @endif

        })
    </script>
    @endpush
</x-layout>