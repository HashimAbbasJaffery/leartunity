<x-layout>
     
    <div class="progression" style="padding: 10px;position: fixed; margin: 0 auto; top: 10px; right: 10px;">
        <div class="progress-bar none" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="--value:5"></div>
    </div>
    <section id="add-section" class="container mx-auto mt-3">
        <h1 style="font-size: 25px; font-weight: 500;">Add Section</h1>
        <div class="course-sections mb-3">
            @foreach ($sections as $section)
                <div class="section flex justify-between mb-3" id="{{ $section->id }}">
                    <p>{{ $section->section_name }}</p>
                    <p>{{ $section->contents->count() }} Videos</p>
                </div>
                <div class="none contents" id="content-{{ $section->id }}">
                    <div class="core-contents" id="core-contents-{{ $section->id }}">
                        @foreach($section->contents as $content)
                            <a href="#" style="margin-bottom: 5px" class="content flex justify-between block">
                                <p style="text-decoration: underline; margin-bottom: 8px;">{{ $content->title }}</p>
                                <p>{{ secondToMinutes($content->duration) }}</p>
                            </a>
                        @endforeach
                    </div>
                    <a href="#" id="contents-{{ $section->id }}"
                        class="create-content create-course rounded text-center py-2"
                        style="width:100%; display: inline-block">
                        <i class="fa-solid fa-plus p-3 rounded-full"
                            style="background: var(--primary); color: white;"></i>
                    </a>
                </div>
            @endforeach
        </div>
        <a href="#" class="create-section create-course rounded text-center py-2"
            style="width:100%; display: inline-block">
            <i class="fa-solid fa-plus p-3 rounded-full" style="background: var(--primary); color: white;"></i>
        </a>
    </section>
    @push('scripts')
        <script>
            const sectionsCard = document.querySelectorAll(".section");
            sectionsCard.forEach(section => {
                section.addEventListener("click", function() {
                    const section_id = section.id;
                    const contents = document.getElementById("content-" + section_id);
                    contents.classList.toggle("none");
                })
            })
        </script>
        <script>
            const section = (name, videos) => {
                return (
                    `
                    <div class="section flex justify-between mb-3">
                        <p>${name}</p>
                        <p>${videos} Videos</p>
                    </div>
                   `
                )
            }
            const createSection = document.querySelector(".create-section");
            const sections = document.querySelector(".course-sections");
            createSection.addEventListener("click", function() {
                Swal.fire({
                    title: "Enter Section name",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    showLoaderOnConfirm: true,

                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        const section_name = result.value;
                        axios.post("{{ route('section.create', ['course' => $course->slug]) }}", {
                                section_name
                            })
                            .then(res => {
                                sections.innerHTML += section(section_name, "1");
                            })
                            .catch(err => {
                                console.log(err)
                            });
                    }
                });
            })
        </script>
        <script>


            const createContents = document.querySelectorAll(".create-content");
            let resumable = new Resumable({
                            target: `/instructor/content/13/add`,
                            method: "POST",
                            query: {
                                _token: '{{ csrf_token() }}'
                            },
                            fileType: ['png', 'jpg', 'jpeg', 'mp4'],
                            chunkSize: 10*1024*1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
                            headers: {
                                'Accept': 'application/json'
                            },
                            testChunks: false,
                            throttleProgressCallbacks: 1,
                        });
                    
                        resumable.on("fileAdded", function(file) {
                            console.log("start")
                        })
                           
                        resumable.on("fileProgress", function(file) {
                            const progressBar = document.querySelector(".progress-bar");
                            const progressStyle = progressBar.style;
                            const progress = Math.floor(file.progress() * 100);
                            progressBar.classList.remove("none")
                            progressStyle.setProperty("--value", progress);
                            console.log(progress)
                        })

                        resumable.on("fileSuccess", function(file) {
                            const progressBar = document.querySelector(".progress-bar");
                            progressBar.style.display = "none";
                            location.reload();
                        })

                        resumable.on('fileError', function (file, response) { // trigger when there is any error
                            console.log(response);
                        });
            createContents.forEach(createContent => {
                createContent.addEventListener("click", function() {
                    const id = createContent.id.split("-")[1];
                    Swal.fire({
                        title: "Add Content",
                        html: '<input type="text" id="content-title" class="mb-2" style="width: 100%; border: 1px solid var(--primary); resize: none" ><textarea id="content-description" type="text" style="width: 100%; border: 1px solid var(--primary); height: 100px; resize: none" class="mb-2" /></textarea>' +
                            "<br>" +
                            "<input id='content-video' style='border: none;width: 100%;' type='file' />",
                        inputAttributes: {
                            autocapitalize: "off"
                        },
                        showCancelButton: true,
                        confirmButtonText: "Save",
                        showLoaderOnConfirm: true,
                        didOpen: function() {
                            const content = document.getElementById("content-video");
                            console.log(resumable.assignBrowse(content)); 
                        },

                        allowOutsideClick: () => !Swal.isLoading(),
                    }).then((result) => {
                     
                        if (result.isConfirmed) {
                            const contentList = document.getElementById("core-contents-" + id);
                            
                            const content = document.getElementById("content-video");
                            const title = document.getElementById("content-title").value;
                            const description = document.getElementById("content-description").value;
                            resumable.opts.query = {
                                ...resumable.opts.query, 
                                title,
                                description
                            }
                            resumable.opts.target = `/instructor/content/${id}/add`
                            const data = new FormData();
                            data.append("content", content.files[0])
                            data.append("title", title.value);
                            data.append("description", description);
                            
                            resumable.upload();

                            
                            

                            // const config = {
                            //     onUploadProgress: progressEvent => {
                            //         const {
                            //             loaded,
                            //             total
                            //         } = progressEvent;
                            //         const progressPercentage = Math.round((loaded * 100) /
                            //             total);
                            //         console.log(`Upload Progress: ${progressPercentage}%`);
                            //     }
                            // };

                            // axios.post(`/instructor/content/${id}/add`, data, config)
                            //     .then(res => {



                            //     })
                            //     .catch(err => {
                            //         console.log(err)
                            //     });
                        }
                    });
                })
            })
        </script>
    @endpush
</x-layout>
