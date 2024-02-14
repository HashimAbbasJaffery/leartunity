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
                <p class="mr-2">50 Followers</p>
                <button class="highlighted px-2">Follow</button>
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
                {!! calculateReviewStars(4.8) !!} (194)
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
</x-layout>