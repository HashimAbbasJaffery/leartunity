<x-layout>
    <div class="profile-intro container mx-auto" style="background: url('https://placehold.co/1120x200') no-repeat; background-size: contain;">
    @if($profile?->profile_pic)
        <div class="profile-pic" style="background: url('/profile/{{ $profile->profile_pic }}');  background-size: cover;">&nbsp;</div>
    @else    
        <div class="profile-pic" style="background: url('https://placehold.co/40x40');  background-size: cover;">&nbsp;</div>
    @endif 
    </div>
    <div class="profile-content container mx-auto flex">
        <aside class="py-4" style="width: 30%;">
            <p style="font-size: 20px; font-weight: 600; margin-bottom: 10px;">{{ $profile->user->name ?? "Dummy Account"}}</p>
            <section id="follows" class="flex mb-3">
                <form method="POST" id="follow">
                    @csrf 
                    <p class="mr-2"><span id="follower-count">{{ $followersCount }}</span> Followers</p>
                    <button style="background: var(--primary);" type="submit" class="follow-button highlighted px-2">{{ ($is_following ? 'Unfollow' : "Follow") }}</button>
                </form>
            </section>
            <h1 style="font-weight: 600;" class="mb-1">Achievments</h1>
            <section class="achievements flex">
                <img src="https://placehold.co/40x40" class="mr-2" style="border-radius: 50px;" />
                <img src="https://placehold.co/40x40" class="mr-2" style="border-radius: 50px;" />
                <img src="https://placehold.co/40x40" class="mr-2" style="border-radius: 50px;" />
                <img src="https://placehold.co/40x40" class="mr-2" style="border-radius: 50px;" />
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
                        :title="$course->title"
                        :instructor="$course->author->name"
                        duration="50"
                        :description="$course->description"
                        :profile="$profile->profile_pic ?? ''"
                        :price="$course->price"
                        :rating="$stars"
                        :stripe="$course->stripe_id"
                        :slug="$course->slug"
                        :thumbnail="$course->thumbnail"
                    />
                @endforeach
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
        const button = document.querySelector(".follow-button")
        const countElement = document.getElementById("follower-count");
        form.addEventListener("submit", function(e) {
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
                })
                .catch(err => {
                    console.log(err)
                })
        })
    </script>

    @endpush 
</x-layout>