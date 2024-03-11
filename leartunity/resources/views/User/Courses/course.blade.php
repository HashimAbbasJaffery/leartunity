<x-layout>
        <main>
          <section class="intro-video container mx-auto">
            <div class="flex">
              <div class="video col-span-2" style="position: relative;">
                  <div class="spinner" style="position: absolute; z-index: 2; background: black; width: 100%; height: 112%; display: flex; align-items: center; justify-content: center; display: none;">
                    <div class="loader"></div>
                  </div>
                <video id="player" playsinline controls data-poster="https://placehold.co/600x400">
                  <source class="video" src="{{ asset('uploads/' . $introduction) }}" type="video/mp4" />
                  <source class="video" src="{{ asset('uploads/' . $introduction) }}" type="video/webm" />
                <!-- Captions are optional -->
                </video>
              </div>
              <div class="playlist container mx-auto">
                <div class="container_playlist">
                  
                  @php
                    $stripe_id = $course->stripe_id;
                    $purchased = auth()->user()?->purchases()->where("purchase_product_id", $stripe_id)->exists();
                  @endphp
                  @foreach($sections as $section)
                  @php 
                    $outerIndex = $loop->index;
                  @endphp
                  <button class="accordion">{{ $section->section_name }}</button>
                  <div class="accordion-content">
                    <ul>
                      @foreach($section->contents as $content)
                        @php 
                          $innerIndex = $loop->index;
                        @endphp 
                        <a data-id="{{ $content->id }}" href="{{ route('getContent', [ 'content' => $content->id ]) }}" class="course-link {{ ($content->is_paid && !$purchased) ? 'paid' : '' }} flex section-link">
                          <li>{{ $outerIndex + 1}}.{{ $innerIndex + 1}} - {{ $content->title }}</li>
                          <time style="font-size: 13px;">
                            {{ secondToMinutes($content->duration) }}
                            @if($content->is_paid && !$purchased)
                              - 
                              <i class="fa-solid fa-lock"></i>
                            @endif
                          </time>
                        </a>
                      @endforeach
                    </ul>
                  </div>
                  @endforeach
                
              </div>
            </div>
          </section>
          <section id="course-content" class="container mx-auto">
            <div class="course-header">
              <p>${{ $course->price }}</p>
            </div>
            <div class="course-details">
              {!! $course->description !!}
              <h1>Pre-Requisites</h1>
              {!! $course->pre_req !!}
              <div class="option">  
                @php 
                  $course_stripe = $course->stripe_id;
                  $is_purchased = auth()->user()?->purchases()->where("purchase_product_id", $course_stripe)->exists();
                @endphp
                @if(!$is_purchased)
                  <a class="highlighted course-highlighted" href="{{ route("checkout", ['id' => $course->stripe_id ]) }}">Enroll</a>
                  <button class="highlighted course-highlighted">Financial-Aid</button>
                @endif
              </div>
            </div>
          </section>
          <section id="instructor" class="course-instruction container mx-auto">
            <div class="course-instructor course-section mt-4 flex">
              <div class="instructor-img">
                @php 
                  $profile = $course->author->profile;
                @endphp 
                @if($profile)
                  <img src="/profile/{{ $profile->profile_pic }}" height="45" width="45" class="rounded-full" alt="">
                @else 
                  <img src="https://placehold.co/45x45" class="rounded-full" alt="">
                @endif 
              </div>
              <div class="instructor-details flex">
                <h2>{{ $course->author->name }}</h2>
                <p>Courses: {{ $course->author->courses->count() }}</p>
              </div>
            </div>
            <div class="instructor-info">
              <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam, iusto omnis. Id unde eligendi optio voluptatibus? Fuga repellendus hic fugiat iure, consequatur non, explicabo excepturi exercitationem repudiandae placeat quo harum?</p>
              <div class="option">  
                <button class="highlighted course-highlighted">Contact Me</button>
                <button class="highlighted course-highlighted">Profile</button>
              </div>
            </div>
          </section>
          
            @if($reviews)
          <section id="reviews" class="container mx-auto">
            <div class="review-header">
              <h1>Reviews</h1>
              <div class="stars">
                <div class="course-rating flex"> 
                  {!! calculateReviewStars($course?->reviews->stars ?? 0) !!}
                  <p class="ml-1">({{ round($course?->reviews->stars, 1) ?? "Not rated yet" }})</p>
                </div>
              </div>
            </div>
            @foreach($reviews as $review)
              <div class="review">
                <div>
                  <div class="course-instructor mt-4 flex">
                    <div class="instructor-img">
                      <img src="https://placehold.co/45x45" class="rounded-full" alt="">
                    </div>
                    <div class="instructor-details flex">
                      <h2>{{ $review?->name ?? "null" }}</h2>
                      <div class="course-rating flex"> 
                        {!! calculateReviewStars($review?->stars ?? 0) !!}
                      </div>
                    </div>
                  </div>
                  <p style="font-size: 13px;" class="mt-2">{{ $review?->review ?? "null" }}</p>
                </div>
              </div>
            @endforeach
            {{ $reviews->links() }}
          </section>
          @else 
            <p class="container mx-auto mb-2">No Reviews yet!</p>
          @endif
          @php 
            $eligibilty = eligibleForReview();
          @endphp 
          {{-- @if($eligibilty["status"] === true)
            <section id="write-review" class="container mx-auto write_review">
              
              <div class="course-rating flex"> 
                <!-- <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                -->

                <i class="fa-regular fa-star feedback-star" data-star="1"></i>
                <i class="fa-regular fa-star feedback-star" data-star="2"></i>
                <i class="fa-regular fa-star feedback-star" data-star="3"></i>
                <i class="fa-regular fa-star feedback-star" data-star="4"></i>
                <i class="fa-regular fa-star feedback-star" data-star="5"></i>
              </div>
              <textarea class="write_review" placeholder="Write Review"></textarea>
              <button class="highlighted" style="padding: 5px 10px 5px 10px;">Submit</button>
            </section>
          @else 
            <div class="container mx-auto mb-2" style="">{{ $eligibilty["message"] }}</div>
          @endif --}}
        </main>
        @push("scripts")
          <script src="{{ asset('js/accordion.js') }}"></script>
          <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
          <script src="{{ asset('js/transition.js') }}"></script>
          <script src="{{ asset('js/feedback.js') }}"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js" integrity="sha512-NQfB/bDaB8kaSXF8E77JjhHG5PM6XVRxvHzkZiwl3ddWCEPBa23T76MuWSwAJdMGJnmQqM0VeY9kFszsrBEFrQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
          <script src="{{ asset("js/changeVideoSource.js") }}"></script>
          <script>
            const player = new Plyr("#player");
            player.source = {
              type: 'video',
              title: 'Example title',
              sources: [
                  {
                      src: '/uploads/{{ $introduction }}',
                      type: 'video/mp4',
                      size: 720,
                  } 
              ],
            }
            const links = document.querySelectorAll(".course-link");
            links.forEach(link => {
              link.addEventListener("click", function(e) {
                e.preventDefault();
                const id = link.dataset.id;
                axios.get(`/content/${id}`)
                  .then(res => {
                    const data = res.data;
                    if(data.type === "success") {

                      changeVideoSource(player, `/uploads/${data.message}`)
                     
                    } else {
                      alert("You are trying you hack... right?");
                    }
                  })
                  .catch(err => {
                    console.log(err);
                  })
              });
            })
          </script>
        @endpush
    </x-layout>
