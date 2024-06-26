<x-layout>
        <main>
            <section id="search-area" class="container mx-auto" style="position: relative;">
                <select class="search-type highlighted p-1 mt-4" style="width: 10%;height: 35px;">
                  <option value="categories">@lang("Categories")</option>
                  <option value="course">@lang("Course")</option>
                  <option value="teachers">@lang("Teachers")</option>
                </select>
                <input type="text" placeholder="@lang('Search for anything!')" style="border-radius: 0px; border: 1px solid #424242;" id="q" name="" />
                <div class="results none" style="overflow: auto;max-height: 300px;border-radius: 5px;border: 1px solid black;right: 0px;position: absolute; background: white; width: 89%; top: 115%; padding-left: 10px;">
                  <div class="teachers results py-2">
                    &nbsp;
                  </div>
                </div>
            </section>
            <div>
            <div id="separator" class="container mx-auto mt-4" style="background: black; height: 2px;">&nbsp;</div>
            <section id="banner" style="background: {{ $quote->bg_color }};" class="text-center">
              <h1 id="sliders" oninput="contentChanged(this)" @can('admin') contenteditable="true" @endcan>
                @lang($quote->quote)
              </h1>
            </section>
          </div>

          <section id="courses" class="container mx-auto">
            <h1 class="text-center">@lang("top courses")</h1>
            <div class="tabs mt-5">
              <ul class="flex">
                @foreach($categories as $category)
                  <li class="tab mx-3 @if($loop->index === 0) active @endif" id="tab{{ $category->id }}" onclick="changeTab({{ $category->id }})" data-tab="{{ $category->id }}">{{ $category->category }}</li>
                @endforeach
              </ul>
            </div>
            @foreach($categories as $category)
              <div class="grid grid-cols-4 gap-4 courses" @if($loop->index > 0 ) style="display: none" @endif data-content="{{ $category->id }}">
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
                          :course="$course"
                        />
                        
                    @endforeach
              </div>
            @endforeach
          </section>
          <!-- <section id="plans">
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
          </section> -->
          <section id="apply-for-teaching" class="container mx-auto flex ">
            <div class="side-image">
              <img src="{{ asset("img/sample.jpg") }}" alt="">
            </div>
            <div class="apply">
              <h1>
                @lang("become teacher?") 
              </h1>
              <p>@lang("Start teaching right away, and arrange live sessions")</p>
              <div class="flex">
                <button onclick="window.location.href = '{{ route('apply') }}'" class="mr-1">@lang("apply")</button>
                <button onclick="window.location.href = '{{ route('apply.learn-more') }}'" style="background: transparent; color: black; border: 1px solid var(--primary)">@lang("Learn More")</button>
              </div>
            </div>
          </section>
        </main>
    @push("scripts")
      
      <script>
        function debounce(func, delay) {
        let timerId;
        
        return function(...args) {
          clearTimeout(timerId);
          timerId = setTimeout(() => {
            func.apply(this, args);
          }, delay);
        };
      }
      </script>
      <script>
        const contentChanged = el => {
          axios.put("{{ route('quote.rename') }}", {
            quote: el.textContent
          })
            .then(res => {
              console.log(res);
            })
            .catch(err => {
              console.log(err);
            })
        }
      </script>
      <script>
        const getImage = (data, path) => {
          //["profile", "profile_pic"]
          path = path.split(".");
          let result = data;
          for(let i = 0; i < path.length; i++) {
            if(!result) {
              return "";
            }
            result = result[path[i]];
          }
          return result;
        }
      </script>
      <script>
        const result = (data, column, path, directory, url) => {
          const imageAttribute = getImage(data, path);
          console.log(directory + imageAttribute);
          const optionalEl = `
            <div class="teacher-pic mr-2">
                  <img class="rounded" src="${( imageAttribute )? directory + imageAttribute : 'https://placehold.co/50x50'}" style="height: 50px; width: 60px;"/>
              </div>
          `
          return `
          <a href="${ url ? url : '#' }">
              <div class="teacher flex mb-4 mt-2">
              ${(column !== "category") ? optionalEl : ""}
              <div class="teacher-detail">
                  <h1 class="mb-0" style="height: 18px;">${data[column]}</h1>
              </div>
              </div>
          </a>
          `
      }
      </script>
      <script>
        const searchQuery = () => {
          const type = document.querySelector(".search-type");
          const keyword = document.getElementById("q");
          axios.get(`/api/search?type=${type.value}&query=${keyword.value}`)
            .then(res => {
              const column = res.data[0];
              const data = res.data[1];
              console.log(data);
              const path = res.data[2];
              const directory = res.data[3];
              const results = document.querySelector(".results");
              let url = "";
              results.textContent = "";
              data.forEach(data => {
                if(type.value === "course") {
                  url = `/course/${data.slug}`; 
                }
                if(type.value === "teachers") {
                  url = `/profile/${data.id}`;
                }
                results.innerHTML += result(data, column, path, directory, url);
              });

              if(!data.length) {
                results.innerHTML = "<p class='py-3'>No result Found</p>";
              }
              
              results.classList.add("show");
              results.classList.remove("none");
            })
            .catch(err => {
              console.log(err)
            })
        }
      </script>
      <script>
        function searchResult() {
          const results = document.querySelector(".results");
          if(search.value) {
            searchQuery();
          } else {
            results.classList.add("none");
            results.classList.remove("show");
          }
        }
      </script>
      <script>
        const search = document.getElementById("q");
        const type = document.querySelector(".search-type");

        search.addEventListener("keyup", debounce(searchResult, 200))
        type.addEventListener("change", debounce(searchResult, 200))
      </script>
    @endpush
</x-layout>
