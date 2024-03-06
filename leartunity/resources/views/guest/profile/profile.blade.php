<x-layout>
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
                    <div class="edit-cover flex" style="top: 0px; width: 25px; height: 25px;">
                        <i class="fa-solid fa-pencil"></i>
                    </div>
                    <input id="profile_pic" type="file" onchange="changePicture(this)" name="profile_pic" class="none picture" />
                </label>
            @endcan
        </div>
        @can("change-pic", $profile)
            <label for="cover">
                <div class="edit-cover flex">
                    <i class="fa-solid fa-pencil"></i>
                </div>
                <input id="cover" type="file" name="cover" onchange="changePicture(this)" class="none picture" />
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
            <h1 style="font-weight: 600;" class="mb-1 mt-3">Level</h1>
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
            <h1 style="font-weight: 600;" class="mb-1 mt-3">Overall Reviews</h1>
            <section class="level">
                {!! calculateReviewStars($avgRating) !!} 
                @if($count > 0)
                    ({{ $count }})
                @endif
            </section>
            <section class="level mt-3">
                <p>Viewings: <span class="views">0</span></p>
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
    <script>

        const changePicture = element => {
            const name = element.getAttribute("name");
            const data = new FormData();
            data.append(name, element.files[0]);
            let parameters = {
                [name]: element.files[0]
            }
            console.log(parameters);
            axios.post("/user/{{ $profile?->id ?? "null" }}/picture", data)
                .then(res => {
                    const data = res.data;
                    data.forEach(data => {
                        const isSuccess = data.type;
                        if(isSuccess === "failed") return;
                        const fileType = data.message.type;
                        const fileName = data.message.file;

                        const element = document.querySelector(`.${fileType}`);
                        const url = `url('${ (fileType === "profile_pic") ? '/profile/' : '/cover/' }${fileName}')`;
                        console.log(url);
                        element.style.backgroundImage = url;
                    }) 
                })
                .catch(err => {
                    console.log(err)
                })
        }          
    </script>
    <script>
        window.onload = function() {
            // Follower Channel
            Echo.channel(`follower.{{ $profile->user_id }}`)
                .listen('FollowerCounter', (e) => {
                        console.log("kaka");
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