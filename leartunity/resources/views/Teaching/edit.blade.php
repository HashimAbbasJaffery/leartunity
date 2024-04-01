<x-layout>
    <section class="mt-5 create-field container mx-auto" style="width: 100%;">
        <form enctype="multipart/form-data" id="update-course" style="width: 100%; display: block;" class="py-2" method="POST" action="{{ route('course.update', [ 'course_slug_o' => $course->slug ]) }}">
        @csrf
        {{ method_field("PUT") }}
            <label for="title" style="display: block; margin-bottom: 20px">
                Course Title
                @error("title")
                    <p class="text-red-600" style="font-size: 13px;">{{ $message }}</p>
                @enderror
                <input type="text" class="rounded px-2 @error('title') has-error @enderror" value="{{ $course->title }}" id="title" name="title" style="width: 100%;"/>
            </label>
            <button type="cancel" class="highlighted px-3 preview mb-1" data-for="description">Preview</button>
            <label for="description" style="display: block; margin-bottom: 20px">
                Description - It supports Github markdown
                @error("description")
                    <p class="text-red-600" style="font-size: 13px;">{{ $message }}</p>
                @enderror
                <textarea id="description" name="description" class="@error('description') has-error @enderror rounded px-2" style="height: 300px;outline: none;resize: none;width: 100%; border: 1px solid var(--primary)">{{ $course->description }}</textarea>
            </label>
            <div class="description-preview none">fjhdf</div>
            <label for="pre_req" style="display: block; margin-bottom: 20px">
                Course Pre Requisites - It supports Github markdown
                @error("pre_req")
                    <p class="text-red-600" style="font-size: 13px;">{{ $message }}</p>
                @enderror
                <textarea id="description" name="pre_req" class="rounded px-2" style="height: 300px;outline: none;resize: none;width: 100%; border: 1px solid var(--primary)">{{ $course->pre_req }}</textarea>
            </label>
            <div class="pre_req-preview none">&nbsp;</div>
            <label for="price" style="display: block; margin-bottom: 20px">
                Price
                @error("price")
                    <p class="text-red-600" style="font-size: 13px;">{{ $message }}</p>
                @enderror
                <input type="number" class="rounded px-2 @error('price') has-error @enderror" value="{{ $course->price }}" id="price" name="price" style="width: 100%;"/>
            </label>
            <label for="thumbnail" style="display: block; margin-bottom: 20px">
                <span class="highlighted px-3 py-2">Upload Thumbnail</span>
                @error("thumbnail")
                    <p class="text-red-600 mt-2" style="font-size: 13px;">{{ $message }}</p>
                @enderror
                <input type="file" class="none rounded px-2 @error('thumbnail') has-error @enderror" id="thumbnail" name="thumbnail" style="width: 100%;"/>
            </label>
            <div id="cropper"></div>
            @error("categories")
                <p class="text-red-600" style="font-size: 13px;">{{ $message }}</p>
            @enderror
            
            <div class="categories rounded mb-3 flex items-start flex-wrap" style="overflow: auto;border: 1px solid black; height: 100px;">
                @foreach($categories as $category)
                    <label class="flex items-center px-2" for="category-{{ $category->id }}">
                        <input class="mr-2 category @error('categories') has-error @enderror" @checked(in_array($category->id, $course->categories_id))  type="checkbox" id="category-{{ $category->id }}" style="width: 15px;"/>
                        {{ $category->category }}
                    </label>
                @endforeach
            </div>
            <input type="text" name="base64" id="base64">
            <input type="hidden" value="{{ implode(",", $course->categories_id) }}" name="categories" id="categories"/>
            <button type="submut" class="highlighted px-3 preview mb-1" data-for="description">Update</button>
        </form>
    </section>
    @push("scripts")
        <script src="/js/Cropper.js"></script>
        <script>
            const thumbnail = document.getElementById("thumbnail");
            let cropper;
            thumbnail.addEventListener("change", function() {
                cropper && cropper.destroy();
                cropper = new Cropper("480", "270", "square", "#cropper");
                cropper.bindPicture(this);
                cropper.upload(function(res) {
                    console.log(res);
                })
            })
            const update = document.getElementById("update-course");
            update.addEventListener("submit", function(e) {
                e.preventDefault();
                cropper.upload(function(res) {
                    const base64 = document.getElementById("base64");
                    base64.value = res;
                    update.submit();
                })
            })
        </script>
        <script>
            const previewButton = document.querySelector(".preview");
            let ids = [];
            const categories = document.querySelectorAll(".category");
            const categoriesInput = document.getElementById("categories");
            categories.forEach(category => {
                category.addEventListener("change", function() {
                    const checkedCategories = document.querySelectorAll(".category:checked");
                    ids = Array.from(checkedCategories).map(category => {
                        return category.id.split("-")[1];
                    });
                    categoriesInput.value = ids;
                })
            })

            previewButton.addEventListener("click", function(e) {
                e.preventDefault();
                const forElement = previewButton.dataset.for;
                const preview = document.querySelector(`.${forElement}-preview`);
                const field = document.getElementById(forElement);
                axios.post(`/preview`, {
                    value: field.value
                })
                    .then(res => {
                        console.log(res)
                        preview.innerHTML = res.data;
                preview.classList.toggle("none");
                    })
                    .catch(err =>{
                        console.log(err)
                    })
            })
        </script>
    @endpush 
</x-layout>