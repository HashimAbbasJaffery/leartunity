<x-layout>

    
        <main>
            <section id="search-area" class="container mx-auto">
                <select class="search-type highlighted p-1 mt-4" style="height: 35px;">
                  <option>Categories</option>
                  <option>Name</option>
                  <option>Teachers</option>
                </select>
                <input type="text" placeholder="Search for anything!" style="border-radius: 0px; border: 1px solid #424242;" id="q" name="" />
            </section>
            <div>
            <div id="separator" class="container mx-auto mt-4" style="background: black; height: 2px;">&nbsp;</div>
            <section id="banner" class="text-center">
              <h1>
                Education is the most important thing
              </h1>
            </section>
          </div>

          <section id="courses" class="container mx-auto">
            <h1 class="text-center">top courses</h1>
            <div class="tabs mt-5">
              <ul class="flex">
                @foreach($categories as $category)
                  <li class="tab mx-3 @if($loop->index === 0) active @endif" id="tab{{ $category->id }}" onclick="changeTab({{ $category->id }})" data-tab="{{ $category->id }}">{{ $category->category }}</li>
                @endforeach
              </ul>
            </div>
            @foreach($categories as $category)
              <div class="grid grid-cols-4 gap-4 courses none" @if($loop->index > 0) style="display: none" @endif data-content="{{ $category->id }}">
                    @foreach($category->courses as $course)
                        @if($loop->index > 7) @break @endif
                        @php
                          $stars = 0;
                          $reviews = $course->reviews;
                          if(isset($reviews->stars)) {
                            $stars = $reviews->stars;
                          }
                        @endphp
                        <x-user.course 
                            :title="$course->title"
                            :instructor="$course->author->name"
                             duration="50"
                            :description="$course->description"
                            :price="$course->price"
                            :rating="$stars"
                            :stripe="$course->stripe_id"
                            :slug="$course->slug"
                        />
                        
                    @endforeach
              </div>
            @endforeach
          </section>
          <section id="plans">
            <div class="container mx-auto" style="max-width: 900px;">
              <h1 class="text-center" style="color: white; margin-bottom: 10px;">plans</h1>
              <div class="plans grid gap-4 grid-cols-2">
                @foreach($plans as $plan)
                  <div class="monthly plan">
                    <h1 style="text-transform: capitalize;">{{ $plan->plan_name }}</h1>
                    <p>${{ $plan->price }}/month</p>
                    <div class="separator">&nbsp;</div>
                    <p>cancel anytime</p>
                    <button>subscribe</button>
                  </div>
                @endforeach
              </div>
            </div>
          </section>
          <section id="apply-for-teaching" class="container mx-auto flex grid grid-cols-2">
            <div class="side-image">
              <img src="./assets/img/sample.jpg" alt="">
            </div>
            <div class="apply">
              <h1>
                become 
                <br>
                teacher?
              </h1>
              <p>Start teaching right away, and arrange live sessions</p>
              <button>apply</button>
            </div>
          </section>
        </main>

</x-layout>
