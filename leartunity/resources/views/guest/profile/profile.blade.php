<x-layout>
    

<!-- Modal toggle -->
<button data-modal-target="default-modal" data-modal-toggle="default-modal" class="open-modal hidden block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
  Toggle modal
</button>

<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" onHide="alert('lol');" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center max-w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Crop Image
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div id="cropper">&nbsp;</div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="button" id="modal-gateway" class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                <button onclick="modal.hide()" data-modal-hide="default-modal" type="button" class="cancel py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
            </div>
        </div>
    </div>
</div>

    @php 
        $file = "https://placehold.co/1120x200";
        if($profile?->cover) {
            $file = "/cover/" . $profile->cover;
        }
        $profilePic = 'https://placehold.co/40x40';
        if($profile?->profile_pic) {
            $profilePic = "/profile/" . $profile->profile_pic;
        }
    @endphp
    <div class="profile-intro container mx-auto cover" style="background: url('{{ $file }}') no-repeat; background-size: cover;">
        <div class="profile-pic profile_pic" style="background: url('{{ $profilePic }}');  background-size: cover;">
            @can("change-pic", $profile)
                <label for="profile_pic">
                    <img src="/frames/basic_frame.png" />
                    <div class="edit-cover flex" style="top: 0px; width: 25px; height: 25px;">
                        <i class="fa-solid fa-pencil"></i>
                    </div>
                    <input id="profile_pic" type="file" onchange="changePicture(this, 'profile')" name="profile_pic" class="none picture" />
                </label>
            @endcan
        </div>
        @can("change-pic", $profile)
            <label for="cover">
                <div class="edit-cover flex">
                    <i class="fa-solid fa-pencil"></i>
                </div>
                <input id="cover" type="file" name="cover" onchange="changePicture(this, 'cover')" class="none picture" />
            </label>
        @endcan
    </div>
    <div class="profile-content container mx-auto flex">
        <aside class="py-4" style="width: 30%;">
            <p style="font-size: 20px; font-weight: 600; margin-bottom: 10px;">{{ $profile->user->name ?? "Dummy Account"}}</p>
            @auth
                <section id="follows" class="flex mb-3">
                    <form method="POST" id="follow">
                        @csrf 
                        <p class="mr-2"><span id="follower-count">{{ $followersCount }}</span> Followers</p>
                        <button style="background: var(--primary);" type="submit" class="follow-button highlighted px-2">{{ ($is_following ? 'Unfollow' : "Follow") }}</button>
                    </form>
                </section>
            @endauth
            <h1 style="font-weight: 600;" class="mb-1">Achievments</h1>
            <section class="achievements flex">
                @forelse($profile->user->achievements as $achievement)
                    @if($loop->index >= 3) @break @endif
                    <img src="/badges/{{ $achievement->achievement_image }}" class="mr-2" style="border-radius: 50px;" height="50" width="50"/>
                @empty 
                    <p style="font-size: 14px;">No badges have been awarded yet!</p>
                @endforelse
            </section>
            
            <!-- <h1 style="font-weight: 600;" class="mb-1 mt-3">Level</h1>
            <section class="level">
                <p>Current Level: <span>5</span></p>
            </section>
            <h1 style="font-weight: 600;" class="mb-1 mt-3">Next level criteria</h1>
            <section class="level">
                <p>Upload 4 Courses</p>
                <p>50 Likes</p>
            </section>
            <h1 style="font-weight: 600;" class="mb-1 mt-3">Next level perks</h1>
            <section class="level">
                <p>Low Tax</p>
            </section>
            <h1 style="font-weight: 600;" class="mb-1 mt-3">Overall Reviews</h1> -->
            <!-- <section class="level">
                {!! calculateReviewStars($avgRating) !!} 
                @if($count > 0)
                    ({{ $count }})
                @endif
            </section> -->
            <section class="level mt-3">
                <p>Watching: <span class="views">0</span></p>
            </section>
            
            <h1 style="font-weight: 600;" class="mb-1 mt-3">Streak</h1>
            <section style="border: 3px solid grey; width: 27px; height: 27px; font-size: 13px;"  class="rounded-full text-black flex items-center justify-center">
                {{ $profile->user->streak }}
            </section>
        </aside>
        <section id="other-info" style="width: 100%;">
            @if(count($courses) > 0)
            <div class="courses grid grid-cols-3 gap-4">
                @foreach($courses as $course)
                    @php
                    $stars = 0;
                    $reviews = $course->reviews;
                    if(isset($reviews->stars)) {
                        $stars = $reviews->stars;
                    }
                    $profile = $course->author->profile;
                    @endphp
                    <x-user.course 
                        :course="$course"
                    />
                @endforeach
                
            </div>
            
                <div class="load-more_section">
                    <button class="highlighted load-more" style="@if(!$courses->hasPages()) display: none; @endif" data-url="{{ $courses->nextPageUrl() }}">Load More</button>
                </div>
            @else
                <div class="text-white p-2 rounded" style="width: 100%; background: var(--primary)">No Courses Found!</div>
            @endforelse
        </section>
    </div>
    @push("scripts")

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="/js/Cropper.js"></script>
    <script>
        const form = document.getElementById("follow");
        const button = document.querySelector(".follow-button");
        const countElement = document.getElementById("follower-count");
        form.addEventListener("submit", function(e) {
        button.textContent = "Processing...";
        button.setAttribute("disabled", "");
            e.preventDefault();
            axios.post("/user/{{ $profile?->id ?? "null" }}/follow")
                .then(res => {
                    const data = res.data;
                    const count = data.message;
                    const status = +data.type;
                    if(!status) {
                        button.textContent = "Unfollow";
                    } else {
                        button.textContent = "follow";
                    }
                    countElement.textContent = count;
                    button.removeAttribute("disabled");
                })
                .catch(err => {
                    console.log(err)
                })
        })
    </script>
    <script type="text/javascript">
        
            
        let $target_el = document.getElementById("default-modal");
        let options = {
            onHide: () => {

            },
            onShow: () => {

            }
        }
        let instanceOptions = {
            id: "default-modal",
            override: true 
        }
        let modal = new Modal($target_el, options, instanceOptions);
        const changePicture = (element, type) => {
            let cropper = new Cropper(134, 134, "circle", "#cropper");
            $image_crop = cropper.get();
            if(type === 'cover') {
                cropper.destroy();
                cropper = new Cropper(856, 300, "square", "#cropper");
                $image_crop = cropper.get();
            }
            cropper.bindPicture(element);
            modal.show();
            modal._options.onHide = function() {
                // $image_crop.unbind();
                // cropper.destroy();
            }
  $('#modal-gateway').click(function(event){
    cropper.upload(function(resp) {
    
    })
    })
        }     
    </script>
    
    <script>
        </script>
    <script>
        window.onload = function() {
            // Follower Channel
            Echo.channel(`follower.{{ $profile->user_id }}`)
                .listen('FollowerCounter', (e) => {
                        const count = document.getElementById("follower-count");
                        count.textContent = e.counts;
                });
            
            // View Channel 
            const views = document.querySelector(".views");
            let viewers = 0;
            Echo.join('profile.{{ $profile->id }}')
                .here((users) => {
                    console.log(users)
                    const length = users.length;
                    viewers = length;
                    views.textContent = length;
                })
                .joining((users) => {
                    viewers++;
                    views.textContent = viewers;
                })
                .leaving((users) => {
                    viewers--;
                    views.textContent = viewers;
                })
                .error((error) => {
                    console.log(error);
                })
        }
    </script>
        <script type="module">
            
            import course from "/js/templates/course.js";
            const loadmore = document.querySelector(".load-more");
            loadmore.addEventListener("click", function() {
                const url = loadmore.dataset.url;
                let parameters = {};
                if(window.parameters) {
                    parameters = window.parameters;
                }
                axios.post(url, parameters)
                    .then(res =>{
                        
                        const next_page_url = res.data.next_page_url;
                        
                        // Loadmore pagination visibility 

                        const loadmore = document.querySelector(".load-more");
                        if(loadmore && !next_page_url) {
                            loadmore.style.display = "none";
                        } else { 
                            loadmore.style.display = "block";
                            loadmore.setAttribute("data-url", next_page_url);
                        }

                        const courses = res.data.data;
                        console.log({courses});
                        const store = document.querySelector(".courses");
                        courses.forEach(data => {
                            console.log(data);
                            store.innerHTML += course(data);
                        })
                        if(courses.length < 1) {
                            store.innerHTML = '<div><p>No course was found!</p></div>';
                        }
                    })
                    .catch(err =>{
                        console.log(err);
                    })
            })
        </script>
    @endpush 
</x-layout>