<x-layout>
    <main>
        <section class="store container mx-auto">
            <aside class="filter-bar">
                <form action="/api/courses" id="submitFilter" style="display: block;">
                    <div class="category-filter filter">
                        <h1>Categories</h1>
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
                        <h1>Price Range</h1>
                        <div class="range-inputs mt-4"> 
                            <label>
                                From ($)
                                <br />
                                <input type="number" class="price_range" style="border-radius: 5px; width: 95%; padding-left: 10px;"/>
                            </label>
                            <label>
                                To ($)
                                <br />
                                <input type="number" class="price_range" style="border-radius: 5px; width: 95%; padding-left: 10px;"/>
                            </label>
                        </div>
                    </div>
                    <div class="search-filter filter mt-3">
                        <h1>Search</h1>
                        <div class="search-bar mt-4 flex">
                            <select id="type" class="search-type highlighted p-1 " style="height: 35px; outline: none; width: 30%; font-size: 14px;">
                                <option>Title</option>
                                <option>Description</option>
                            </select>
                            <input id="q" type="text" style="border-radius: 0px; outline: none; padding-left: 10px; width: 70%;"/>
                        </div>
                    </div>
                    <input type="submit" value="Apply Filters" class="mt-3"  style="cursor: pointer;width: 100%; border-radius: 5px; font-size: 14px;"/>
                </form>
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
                <div class="load-more_section">
                    <button class="highlighted load-more">Load More</button>
                </div>
            </div>
        </section>
    </main>
    @push("scripts")
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script type="module">
            import course from "./js/templates/course.js";
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

                if(flag === true && (prices[0].value <= prices[1].value)) {
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

                axios.post("/courses", {
                    categories: checkedIds,
                    price_range: priceRange,
                    search: JSON.stringify(search)
                })
                    .then(res => {
                        const courses = res.data.data;
                        console.log(courses);
                        const store = document.querySelector(".store-cards");
                        store.innerHTML = "";
                        courses.forEach(data => {
                            console.log(data);
                            store.innerHTML += course(data);
                        })
                        if(courses.length < 1) {
                            store.innerHTML = '<div><p>No course was found!</p></div>';
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    });
            })
        </script>
    @endpush 
</x-layout>