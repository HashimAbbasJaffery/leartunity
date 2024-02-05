<x-layout>
        <main>
          <section class="intro-video container mx-auto">
            <div class="flex">
              <div class="video col-span-2">
                <video id="player" playsinline controls data-poster="https://placehold.co/600x400">
                  <source src="./assets/videos/dummy.mp4" type="video/mp4" />
                  <source src="./assets/videos/dummy.mp4" type="video/webm" />
                <!-- Captions are optional -->
                </video>
              </div>
              <div class="playlist container mx-auto">
                <div class="container_playlist">
                  
                
                  @foreach($sections as $section)
                  <button class="accordion">{{ $section->section_name }}</button>
                  <div class="accordion-content">
                    <ul>
                      <a class="flex section-link">
                        <li>1 - Dummy Course</li>
                        <time>
                          10:00
                          - 
                          <i class="fa-solid fa-lock"></i>
                        </time>
                      </a>
                      <a class="paid flex section-link">
                        <li>1 - Dummy Course</li>
                        <time>
                          10:00
                          - 
                          <i class="fa-solid fa-lock"></i>
                        </time>
                      </a>
                      <a class="paid flex section-link">
                        <li>1 - Dummy Course</li>
                        <time>
                          10:00
                          - 
                          <i class="fa-solid fa-lock"></i>
                        </time>
                      </a>
                      <a class="paid flex section-link">
                        <li>1 - Dummy Course</li>
                        <time>
                          10:00
                          - 
                          <i class="fa-solid fa-lock"></i>
                        </time>
                      </a>
                      <a class="paid flex section-link">
                        <li>1 - Dummy Course</li>
                        <time>
                          10:00
                          - 
                          <i class="fa-solid fa-lock"></i>
                        </time>
                      </a>
                      <a class="paid flex section-link">
                        <li>1 - Dummy Course</li>
                        <time>
                          10:00
                          - 
                          <i class="fa-solid fa-lock"></i>
                        </time>
                      </a>
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
              {{-- <p>You should have basic understating of the simple programming, you should have knowledge about elementary mathematics</p> --}}
              <div class="option">  
                <button class="highlighted course-highlighted">Enroll</button>
                <button class="highlighted course-highlighted">Financial-Aid</button>
              </div>
            </div>
          </section>
          <section id="instructor" class="course-instruction container mx-auto">
            <div class="course-instructor course-section mt-4 flex">
              <div class="instructor-img">
                <img src="https://placehold.co/45x45" class="rounded-full" alt="">
              </div>
              <div class="instructor-details flex">
                <h2>{{ $course->author->name }}</h2>
                <div class="course-rating flex"> 
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                </div>
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
          <section id="reviews" class="container mx-auto">
            <div class="review-header">
              <h1>Reviews - 5</h1>
              <div class="stars">
                <div class="course-rating flex"> 
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
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
                      <h2>{{ $review->name }}</h2>
                      <div class="course-rating flex"> 
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                      </div>
                    </div>
                  </div>
                  <p style="font-size: 13px;">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis cum reprehenderit, necessitatibus placeat commodi eaque, ullam sit eveniet mollitia, omnis fuga rem soluta vel iste atque sapiente nam optio ducimus perferendis? Eos laudantium itaque eaque maxime laborum consequatur modi nisi. Cupiditate atque qui obcaecati provident dolores doloribus praesentium placeat aliquid!</p>
                </div>
              </div>
            @endforeach
            {{ $reviews->links() }}
          </section>
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
        </main>
        @push("scripts")
          <script src="{{ asset('js/accordion.js') }}"></script>
          <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
          <script src="{{ asset('js/transition.js') }}"></script>
          <script src="{{ asset('js/feedback.js') }}"></script>
        @endpush
    </x-layout>
