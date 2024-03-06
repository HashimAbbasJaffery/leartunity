<x-layout>
    <section class="container mx-auto mt-5">
        <div class="store-section" style="width: 100%;">
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
    <section id="add-course" class="container mx-auto">
        <a href="#" class="create-course rounded text-center py-2" style="width:100%; display: inline-block">
            <i class="fa-solid fa-plus p-3 rounded-full" style="background: var(--primary); color: white;"></i>
        </a>
    </section>
    @push("scripts")
    
    <script type="module">
            
        import course from "../js/templates/course.js";
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
                    console.log(courses);
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