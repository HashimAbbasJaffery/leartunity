<x-layout>
    <section id="purchased-courses" class="container mx-auto mt-10">
        @forelse($purchases as $purchase)
        @php 
            $reviews = $purchase->course?->reviews?->reviews ?? null;
            $reviewCount = 0;
            if($reviews) {
                $reviewCollection = array_filter($reviews, function($review) {
                    return $review?->id == auth()->user()?->id;
                });
                $reviewCount = count($reviewCollection);
            }
        @endphp 
            <div class="course flex" style="position: relative;">
                <div class="course-image mr-5" style="width: 20%">
                    <img src="{{ ( $purchase?->course?->thumbnail ?? 'null' )? "/course/" . ($purchase?->course?->thumbnail ?? 'null') : 'https://placehold.co/600x400' }}" height="250" width="250" class="rounded" />
                </div>
                <div class="course-detail" style="width: 80%">
                    <h1 class="text-xl mb-2" style="font-weight: 600;">{{ $purchase->course?->title ?? "null" }}</h1>
                    <p>{{ substr(str_replace("</p>", "", str_replace("<p>", "", $purchase->course?->description ?? "null")),0, 180) }}...</p>
                    <a href="/profile/{{ $purchase->course?->author->id ?? "null" }}" style="font-size: 13px;" class="mt-2 mb-2">{{ $purchase->course?->author->name ?? "null"}}</a>
                    <div class="progress mt-2">
                        @php 
                            $progress = $purchase->course?->tracker->progress ?? "null";
                        @endphp
                        @if($progress < 100)
                        <p style="font-size: 13px; float: right;">{{ $progress }}%</p>
                        <div class="progress-bar" style="background: rgb(222, 222, 222); height: 2px;">
                            <div class="completed-progress" style="background: var(--primary); height: 2px; width: {{ $progress }}%;">&nbsp;</div>
                        </div>
                        @else 
                            <a class="highlighted px-4 py-1" href="/learn/certificate/{{ $purchase->course?->id ?? "null" }}">download certificate</a>
                        @endif
                        
                        <div class="mt-4 inline-block">
                            @if($progress >= 25 && $reviewCount === 0)
                                <a class="give-review highlighted px-4 py-1 bg-green-500 hover:bg-green-600" data-id="{{ $purchase->course?->id ?? "null" }}">Give Review</a>
                            @endif
                            <a id="edit-review-{{ $purchase->course?->id ?? "null" }}" data-id="{{ $purchase->course?->id  ?? "null"}} style="display: none" class="edit-review none highlighted px-4 py-1 bg-yellow-500 hover:bg-yellow-600" data-id="{{ $purchase->course?->id ?? "null" }}">Edit     Review</a>
                            @if($reviewCount > 0)
                                <a class="edit-review highlighted px-4 py-1 bg-yellow-500 hover:bg-yellow-600" data-id="{{ $purchase->course?->id ?? "null" }}">Edit Review</a>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('watch.course', ['course' => $purchase->course?->slug ?? "null", 'content' => $purchase->course?->sections[0]?->contents[0]?->id ?? 'null']) }}" style="text-align:center; width: 10%;padding: 3px 6px 3px 6px;position: absolute; right: 0px;" class="highlighted">Resume</a>
            </div>
        @empty 
            <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>Oops! No course foumd! Time to grab your learning cap and join the fun by purchasing <a style="text-decoration: underline;" href="/courses">Courses</a>! 🎓😄</p>
            </div>
        @endforelse
        
    </section>
    @push("scripts")
    <script src="{{ asset('js/transition.js') }}"></script>
          <script src="{{ asset('js/feedback.js') }}"></script>
          
        <script>

            const buttons = document.querySelectorAll(".give-review");
            const editButtons = document.querySelectorAll(`.edit-review`);

            editButtons.forEach(button => {
                const id = button.dataset.id;
                button.addEventListener("click", function() {
                    Swal.fire({
                    title: "Leave an Honest Review!",
                    input: "text",
                    html: `<div class="stars" style="font-size: 25px;">
                                <i class="fa-solid fa-star feedback-star starred" data-star="1" onmouseover="mouseoverStar(this)" style="cursor: pointer;"></i>
                                <i class="fa-regular fa-star feedback-star" data-star="2" onmouseover="mouseoverStar(this)" style="cursor: pointer;"></i>
                                <i class="fa-regular fa-star feedback-star" data-star="3" onmouseover="mouseoverStar(this)" style="cursor: pointer;"></i>
                                <i class="fa-regular fa-star feedback-star" data-star="4" onmouseover="mouseoverStar(this)" style="cursor: pointer;"></i>
                                <i class="fa-regular fa-star feedback-star" data-star="5" onmouseover="mouseoverStar(this)" style="cursor: pointer;"></i>
                            </div>`,
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Give Review",
                    showLoaderOnConfirm: true,

                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        let stars = document.querySelectorAll(".starred");
                        const feedback = result.value;
                        stars = stars.length;
                        axios.put(`/review/${id}/update`, {
                                feedback,
                                stars
                            })
                            .then(res => {
                                
                            })
                            .catch(err => {
                                console.log(err)
                            });
                    }
                });
                })
            })

            buttons.forEach(button => {
                const id = button.dataset.id;
                button.addEventListener("click", function() {
                
                    Swal.fire({
                    title: "Leave an Honest Review!",
                    input: "text",
                    html: `<div class="stars" style="font-size: 25px;">
                                <i class="fa-solid fa-star feedback-star starred" data-star="1" onmouseover="mouseoverStar(this)" style="cursor: pointer;"></i>
                                <i class="fa-regular fa-star feedback-star" data-star="2" onmouseover="mouseoverStar(this)" style="cursor: pointer;"></i>
                                <i class="fa-regular fa-star feedback-star" data-star="3" onmouseover="mouseoverStar(this)" style="cursor: pointer;"></i>
                                <i class="fa-regular fa-star feedback-star" data-star="4" onmouseover="mouseoverStar(this)" style="cursor: pointer;"></i>
                                <i class="fa-regular fa-star feedback-star" data-star="5" onmouseover="mouseoverStar(this)" style="cursor: pointer;"></i>
                            </div>`,
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Give Review",
                    showLoaderOnConfirm: true,

                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        let stars = document.querySelectorAll(".starred");
                        const feedback = result.value;
                        stars = stars.length;
                        axios.post(`/review/${id}`, {
                                feedback,
                                stars
                            })
                            .then(res => {
                                console.log(res);
                                if(res.data === 1) {
                                    button.classList.add("none");
                                    const edit = document.getElementById(`edit-review-${id}`);
                                    edit.classList.remove("none");
                                }
                            })
                            .catch(err => {
                                console.log(err)
                            });
                    }
                });
                })
            })
        </script>
    @endpush
</x-layout>