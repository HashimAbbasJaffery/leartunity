<x-layout>
    <main>
        <x-admin-navbar />
        <section class="container mx-auto">
            <p>@lang('Main Color')</p>
            <div class="choose-color flex items-center">
                <form class="inline flex items-center" method="POST" action="{{ route('admin.swatch.create') }}">
                    @csrf
                    <input type="color" id="color-picker" name="hexColor" style="border: none; width: 90%;" value="{{ $setting?->primary_color ?? "black" }}">
                    <input type="submit" value="@lang('Add To Swatch')" style="cursor: pointer;border-radius: 0px; width: 10%; font-size: 13px; height: 25px;">
                </form>
            </div>
            <div class="swatches flex mt-3 flex-wrap" style="width: 40%;">
                @foreach($swatches as $swatch)
                    <label>
                        <div class="color mb-4 mr-2" data-color="{{ $swatch->hexColor }}" style="cursor: pointer;background: {{ $swatch->hexColor }}; width: 20px; height: 20px;">&nbsp;</div>
                        <input type="radio" name="" class="none">
                    </label>

                @endforeach

            </div>
            <input type="submit" class="block mb-4 change-color" value="@lang('Change Color')" style="cursor: pointer;border-radius: 0px; width: 20%; font-size: 13px; height: 25px;">
        </section>
        <section class="choose-fonts container mx-auto">
            <h1>@lang('Search Google Fonts')</h1>
            <input type="text" class="rounded mb-4" name="search-fonts" id="search-fonts" style="border-radius: 0px; height: 25px;">
            <div class="none searched-result">
                <h1>@lang('Font')</h1>
                <div class="font block px-2 py-3 mb-3 rounded flex items-center justify-between" style="font-size: 20px; border: 1px solid black; width: 100%;">
                    <p class="preview-phrase">@lang('The quick brown fox jumps over the lazy dog.')</p>
                    <label for="font-1" class="flex">
                        <input type="radio" id="font-1" name="" class="none">
                        <!-- <button style="font-size: 13px;" class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 mr-2">Add To Saved Fonts</button> -->
                        <button style="font-size: 13px;" data-link="" data-name="" class="choose bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">@lang('Click to Choose')</button>
                    </label>
                </div>
            </div>
        </section>
    </main>
    @push("scripts")
        <script>
            const changeColor = document.querySelector(".change-color");
            changeColor.addEventListener("click", function() {
                const primary_color = (document.getElementById("color-picker")).value;
                // alert(hexColor.value);
                axios.put("{{ route('admin.color.update') }}", {
                    primary_color
                })
                    .then(res => {
                        location.reload();
                    })
                    .catch(err => {
                        console.log(err)
                    })
            })
        </script>
        <script>
            const choose = document.querySelector(".choose");

            choose.addEventListener("click", function() {
                const fontLink = choose.dataset.link;
                const fontName = choose.dataset.name;

                axios.put("{{ route("admin.font.update") }}", {
                    font_link: fontLink,
                    font_family: fontName
                })
                    .then(res => {
                        location.reload();
                    })
                    .catch(err => {
                        console.log(err)
                    })
            })
        </script>
        <script>
            const colors = document.querySelectorAll(".color");

            colors.forEach(color => {
                color.addEventListener("click", function() {
                    const colorPicker = document.getElementById("color-picker");
                    colorPicker.value = color.dataset.color;
                })
            })
        </script>
        <script>
            const fonts = document.getElementById("search-fonts");
            fonts.addEventListener("keyup", function(e) {
                axios.get(`https://www.googleapis.com/webfonts/v1/webfonts?key={{ env('GOOGLE_FONTS_API_KEY') }}&family=${e.target.value}`)
                    .then(res => {
                        const result = document.querySelector(".searched-result");
                        const preview = document.querySelector(".preview-phrase");
                        result.classList.remove("none");
                        const chooseFont = document.querySelector(".choose");


                        let link = document.createElement('link');
                        link.rel = 'stylesheet';
                        link.href = `https://fonts.googleapis.com/css2?family=${res.data.items[0].family}:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap`;
                        // document.head.innerHTML += file;
                        document.head.appendChild(link);
                        preview.style.fontFamily = `'${res.data.items[0].family}', sans-serif`
                        chooseFont.dataset.name = `'${res.data.items[0].family}', sans-serif`;
                        chooseFont.dataset.link = link.href;
                    })
                    .catch(err => {
                        const result = document.querySelector(".searched-result");
                        result.classList.add("none");
                    });
            })
        </script>
    @endpush
</x-layout>
