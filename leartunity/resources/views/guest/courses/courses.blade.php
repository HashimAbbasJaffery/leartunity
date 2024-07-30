<x-layout>
    <main>
        <section class="store container mx-auto">
            <aside class="filter-bar">
                <form action="/api/courses" id="submitFilter" style="display: block;">
                    <div class="category-filter filter">
                        <h1>@lang("Categories")</h1>
                        <ul class="mt-4">
                            @foreach($categories as $category)
                                <li>
                                    <label for="category-{{ $category->id }}">
                                        <input type="checkbox" id="category-{{ $category->id }}" data-id="{{ $category->id }}" class="category-checkbox mr-2" style="height: 13px; width: 13px;" />
                                        {{ $category->category }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="price-range filter mt-3">
                        <h1>@lang("Price Range")</h1>
                        @php
                            $user = \App\Models\User::find(auth()->id())?->currency;
                        @endphp
                        <div class="range-inputs mt-4">
                            <label>
                                @lang("From") ({{ $user?->unit ?? "$"}})
                                <br />
                                <input type="number" class="price_range" style="border-radius: 5px; width: 95%; padding-left: 10px;"/>
                            </label>
                            <label>
                                @lang("To") ({{ $user?->unit ?? "$" }})
                                <br />
                                <input type="number" class="price_range" style="border-radius: 5px; width: 95%; padding-left: 10px;"/>
                            </label>
                        </div>
                    </div>
                    <div class="search-filter filter mt-3">
                        <h1>@lang("Search")</h1>
                        <div class="search-bar mt-4 flex">
                            <select id="type" class="search-type highlighted p-1 " style="height: 35px; outline: none; width: 30%; font-size: 14px;">
                                <option>@lang("Title")</option>
                                <option>@lang("Description")</option>
                            </select>
                            <input id="q" type="text" style="border-radius: 0px; outline: none; padding-left: 10px; width: 70%;"/>
                        </div>
                    </div>
                    <input type="submit" value="@lang('Apply Filters')" class="mt-3"  style="cursor: pointer;width: 100%; border-radius: 5px; font-size: 14px;"/>
                </form>
                <input style="background: transparent; color: black;font-size: 14px; cursor: pointer;text-align: center;width: 100%; border-radius: 5px; padding-left: 10px;" type="submit" value="@lang('Clear Filters')" class="mt-3" id="clear-filter"/>
            </aside>
            <div class="store-section">
                <div class="grid grid-cols-3 gap-4 store-cards">
                <div class="course">
    <div class="course-header" style="position: relative;">
        @php
            $author = $course->author->id ?? "null";
        @endphp
        @if($author === auth()->id())
        @if(request()->routeIs("instructor"))
                <label class="switch" style="position: absolute; left: 13px; top: 10px;">
                    <input type="checkbox" @checked($course->status) class="course-switch" id="course-{{ $course->id }}">
                    <span class="slider round"></span>
                </label>
                <div style="position: absolute; bottom: 10px; right: 10px;" class="flex">
                    <form class="mr-2" action="{{ route("course.delete", [ 'course_slug_o' => $course->slug ?? 'nnull']) }}" method="POST" name="courseDelete" id="courseDelete">
                        {{ method_field("DELETE") }}
                        @csrf
                        <button class="text-white px-2 rounded bg-red-500 hover:bg-red-600">@lang("Delete")</button>
                    </form>
                    <form action="{{ route("course.edit", [ 'course_slug_o' => $course->slug ?? 'null' ]) }}" name="courseDelete" id="courseDelete">
                        @csrf
                        <button class="text-white px-2 rounded bg-blue-500 hover:bg-blue-600">@lang("Update")</button>
                    </form>
                </div>
            @endif
        @endif
        @if($is_purchased)
            <div class="course-pill bg-black text-white px-2 py-1 text-xs" style="position: absolute; right: 10px; top: 10px; border-radius: 10px;">
                <p>@lang("Purchased")</p>
            </div>
        @endif
        @if($course->thumbnail)
            <img src="/course/{{ $course->thumbnail }}" style="border-radius: 10px;" height="600" width="400" alt="">
        @else
            <img src="https://placehold.co/600x400" height="600" width="400" alt="">
        @endif
    </div>
    <a href="{{ route("user.profile", ["id" => $course->author?->id ?? 1]) }}">
        <div class="course-instructor mt-4 flex">
            <div class="instructor-img">
                @if($course->author?->profile)
                    <img src="/profile/{{ $course->author->profile->profile_pic }}" height="45" width="45"  class="rounded-full" alt="">
                @else
                    <img src="https://placehold.co/45x45" height="45" width="45"  class="rounded-full" alt="">
                @endif
            </div>
            <div class="instructor-details flex">
                <h2>{{ $course->author?->name }}</h2>
                <div class="course-rating flex">
                    {!! calculateReviewStars($course->reviews?->stars) !!}
                </div>
            </div>
        </div>
    </a>

    <div class="course-detail mt-4">
        <div class="course-description">
            <h1 style="font-size: 15px; font-weight: bold; margin-bottom: 5px;">
                {{ $course->title }}
            </h1>
            {!! substr($course->description, 0, 80) !!}...
        </div>
        <div class="course-options mt-2">
            @if(!$is_purchased)
                <a href="{{ route("checkout", ['id' => $course->stripe_id ?? 'null' ]) }}">@lang("enroll")</a>
            @else

            @endif
            <a href="{{ route('course', [ 'course' =>  $course->slug ?? 'null']) }}">@lang("see details")</a>

            @if($author === auth()->id())
                <a href="{{ route('course.show', ["course_slug_o" => $course->slug ?? 'null']) }}">@lang("Manage")</a>
            @endif
        </div>
        <div class="course-price flex justify-between">
            <p>{{ round($course->price * ($rate ?? 1)) }} {{ $currency?->unit ?? "$" }}</p>
            <p>@lang("Duration"): {{ secondsToHours($course->contents_sum_duration) }}</p>
        </div>
    </div>
</div>

                </div>
                <div class="load-more_section">
                    <button class="highlighted load-more" style="@if(!$courses->hasPages()) display: none; @endif" data-url="{{ $courses->nextPageUrl() }}">Load More</button>
                </div>
            </div>
        </section>
    </main>
    @push("scripts")
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script type="module">
            import course from "./js/templates/course.js";
            const lol = "lol";
            const form = document.querySelector("#submitFilter");

            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const checkboxes = document.querySelectorAll(".category-checkbox:checked");

                // Categories Data gathering
                let checkedIds = [];
                checkboxes.forEach(checkbox => {
                    const id = checkbox.dataset.id;
                    checkedIds.push(id)
                });

                // Price Range Data gathering
                let priceRange = [];
                let prices = document.querySelectorAll(".price_range");

                // Converting nodelist into an array

                prices = Array.from(prices);
                console.log(prices);

                const flag = prices.every(price => {
                    return price.value !== "" && price.value >= 0;
                })

                // Checking if from < to or not

                if(flag === true && (+prices[0].value <= +prices[1].value)) {
                    priceRange.push(prices[0].value);
                    priceRange.push(prices[1].value);
                }

                // Getting the searched keyword from use
                let search = [];
                const keyword = document.getElementById("q");
                const type = document.getElementById("type");

                if(keyword.value) {
                    search = {
                        type: type.value,
                        keyword: keyword.value
                    }
                };
                window.parameters = {
                    categories: checkedIds,
                    price_range: priceRange,
                    search: JSON.stringify(search)
                };
                axios.post("/get/courses", {
                    categories: checkedIds,
                    price_range: priceRange,
                    search: JSON.stringify(search)
                })
                    .then(res => {
                        console.log(res);
                        const next_page_url = res.data.next_page_url;
                        console.log(next_page_url);

                        // Loadmore pagination visibility

                        const loadmore = document.querySelector(".load-more");
                        if(loadmore && !next_page_url) {
                            loadmore.style.display = "none";
                        } else {
                            if(loadmore) {
                                loadmore.style.display = "block";
                                loadmore.setAttribute("data-url", next_page_url);
                            }
                        }
                        const courses = res.data.data;
                        const store = document.querySelector(".store-cards");
                        store.innerHTML = "";
                        courses.forEach(data => {
                            const unit = "{{ App\Models\Currency::find(auth()->user()?->currency_id)?->unit ?? false }}"
                            store.innerHTML += course(data, '{{ auth()->id() }}', '{{ App\Helpers\exchange_rate(App\Models\Currency::find(auth()->user()?->currency_id)?->currency ?? false) }}', unit);
                        })
                        if(courses.length < 1) {
                            store.innerHTML = '<div><p>No course was found!</p></div>';
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    });
            })

            const clear = document.getElementById("clear-filter");
            clear.addEventListener("click", function() {
                const checkboxes = document.querySelectorAll(".category-checkbox:checked");
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });

                const prices = document.querySelectorAll(".price_range");
                prices.forEach(price => {
                    price.value = "";
                })

                const keyword = document.getElementById("q");
                keyword.value = "";
            });
        </script>
        <script type="module">

            import course from "./js/templates/course.js";
            const loadmore = document.querySelector(".load-more");
            loadmore.addEventListener("click", function() {
                const url = loadmore.dataset.url;
                let parameters = {};
                if(window.parameters) {
                    parameters = window.parameters;
                }
                console.log(url);
                axios.post(url, parameters)
                    .then(res =>{
                        console.log(res);
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
                        const store = document.querySelector(".store-cards");
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
