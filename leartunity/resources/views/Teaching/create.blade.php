<x-layout>
    <section class="mt-5 create-field container mx-auto" style="width: 100%;">
        <form enctype="multipart/form-data" style="width: 100%; display: block;" class="py-2" method="POST" action="{{ route('course.create') }}">
            @csrf
            <label for="title" style="display: block; margin-bottom: 20px">
                Course Title
                <input type="text" class="rounded px-2" id="title" name="title" style="width: 100%;"/>
            </label>
            <button type="cancel" class="highlighted px-3 preview mb-1" data-for="description">Preview</button>
            <label for="description" style="display: block; margin-bottom: 20px">
                Description - It supports Github markdown
                <textarea id="description" name="description" class="rounded px-2" style="height: 300px;outline: none;resize: none;width: 100%; border: 1px solid var(--primary)"></textarea>
            </label>
            <div class="description-preview none">fjhdf</div>
            <label for="pre_req" style="display: block; margin-bottom: 20px">
                Course Pre Requisites - It supports Github markdown
                <textarea id="description" name="pre_req" class="rounded px-2" style="height: 300px;outline: none;resize: none;width: 100%; border: 1px solid var(--primary)"></textarea>
            </label>
            <div class="pre_req-preview none">&nbsp;</div>
            <label for="price" style="display: block; margin-bottom: 20px">
                Price
                <input type="number" class="rounded px-2" id="price" name="price" style="width: 100%;"/>
            </label>
            <label for="thumbnail" style="display: block; margin-bottom: 20px">
                <span class="highlighted px-3 py-2">Upload Thumbnail</span>
                <input type="file" class="none rounded px-2" id="thumbnail" name="thumbnail" style="width: 100%;"/>
            </label>
            <button type="submut" class="highlighted px-3 preview mb-1" data-for="description">Preview</button>
        </form>
    </section>
    @push("scripts")
        <script>
            const previewButton = document.querySelector(".preview");

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