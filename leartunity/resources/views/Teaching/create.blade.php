<x-layout>
    <section class="mt-5 create-field container mx-auto" style="width: 100%;">
        <form enctype="multipart/form-data" id="create-course" style="width: 100%; display: block;" class="py-2" method="POST" action="{{ route('course.create') }}">
            @csrf
            <label for="title" style="display: block; margin-bottom: 20px">
                @lang("Course Title")
                @error("title")
                    <p class="text-red-600" style="font-size: 13px;">{{ $message }}</p>
                @enderror
                <input type="text" class="rounded px-2 @error('title') has-error @enderror" value="{{ old("title") }}" id="title" name="title" style="width: 100%;"/>
            </label>
            <label for="description" style="display: block; margin-bottom: 20px">
                @lang("Description - It supports Github markdown")
                @error("description")
                    <p class="text-red-600" style="font-size: 13px;">{{ $message }}</p>
                @enderror
                <textarea id="description" name="description" class="@error('description') has-error @enderror rounded px-2" style="height: 300px;outline: none;resize: none;width: 100%; border: 1px solid var(--primary)">{{ old("description") }}</textarea>
            </label>
            <label for="pre_req" style="display: block; margin-bottom: 20px">
                @lang("Course Pre Requisites - It supports Github markdown")
                @error("pre_req")
                    <p class="text-red-600" style="font-size: 13px;">{{ $message }}</p>
                @enderror
                <textarea id="description" name="pre_req" class="rounded px-2" style="height: 300px;outline: none;resize: none;width: 100%; border: 1px solid var(--primary)">{{ old("pre_req") }}</textarea>
            </label>
            <label for="price" style="display: block; margin-bottom: 20px">
                @lang("Price")
                @error("price")
                    <p class="text-red-600" style="font-size: 13px;">{{ $message }}</p>
                @enderror
                <div class="flex">
                    <input type="number" class="rounded px-2 @error('price') has-error @enderror" value="{{ old("price") }}" id="price" name="price" style="width: 95%;"/>
                    <div class="currency-symbol bg-black text-white items-center justify-center flex text-xl" style="width: 5%">{{ \App\Models\User::find(auth()->id())->currency->unit }}</div>
                </div>
            </label>
            <label for="thumbnail" style="display: block; margin-bottom: 20px">
                <span class="highlighted px-3 py-2">@lang("Upload Thumbnail")</span>
                @error("thumbnail")
                    <p class="text-red-600 mt-2" style="font-size: 13px;">{{ $message }}</p>
                @enderror
                <input type="file" class="none rounded px-2 @error('thumbnail') has-error @enderror" id="thumbnail" name="thumbnail" style="width: 100%;"/>
            </label>
            <div id="cropper">&nbsp;</div>
            @error("categories")
                <p class="text-red-600" style="font-size: 13px;">{{ $message }}</p>
            @enderror
            
            <div class="categories rounded mb-3 flex items-start flex-wrap" style="overflow: auto;border: 1px solid black; height: 100px;">
                @foreach($categories as $category)
                    <label class="flex items-center px-2" for="category-{{ $category->id }}">
                        <input class="mr-2 category @error('categories') has-error @enderror" type="checkbox" id="category-{{ $category->id }}" style="width: 15px;"/>
                        {{ $category->category }}
                    </label>
                @endforeach
            </div>
            <input type="text" name="base64" id="base64">
            <input type="hidden" name="categories" id="categories"/>
            <button type="submut" class="highlighted px-3 preview mb-1" data-for="description">@lang("Create")</button>
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
            const create = document.getElementById("create-course");
            create.addEventListener("submit", function(e) {
                e.preventDefault();
                cropper.upload(function(res) {
                    const base64 = document.getElementById("base64");
                    base64.value = res;
                    create.submit();
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

       
        </script>
    @endpush 
</x-layout>