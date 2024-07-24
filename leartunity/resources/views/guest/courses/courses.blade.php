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
                    @foreach($courses as $course)
                            @if($loop->index > 7) @break @endif
                            @php
                            $stars = 0;
                            $reviews = $course->reviews;
                            if(isset($reviews->stars)) {
                                $stars = $reviews->stars;
                            }
                            $profile = $course->author->profile;
                            @endphp
                            <!-- <x-user.course
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
                                :status="true"
                            /> -->
                            <x-user.course
                                :course="$course"
                            />

                        @endforeach
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
                            const unit = "{{ App\Models\Currency::find(auth()->user()?->currency_id)->unit }}"
                            store.innerHTML += course(data, '{{ auth()->id() }}', '{{ App\Helpers\exchange_rate(App\Models\Currency::find(auth()->user()?->currency_id)->currency) }}', unit);
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
