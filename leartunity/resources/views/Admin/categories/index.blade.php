<x-layout>
    <main>
        <x-admin-navbar />
        <section id="users" class="container mx-auto">


<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    
    <div class="search flex justify-end mr-3">
        <form name="q" id="q">
            <input type="text" value="{{ $keyword }}" name="keyword" id="search" style="border-radius: 0px; width: 20%; height: 25px; font-size: 14px; padding-left: 10px;" placeholder="Enter Category">
            <input type="submit" value="Search" style="border-radius: 0px; width: 5%; font-size: 12px; height: 25px; padding: 0px;">
        </form>
    </div>
    <button type="button" data-context="1" class="create-new status text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 ml-2 mt-2">Create</button>
        
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Courses
                </th>
                <th scope="col" class="px-6 py-3">
                    Since
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">{{ $category->category }}</td>
                <td class="px-6 py-4">{{ $category->courses()->count() }}</td>
                <td class="px-6 py-4">{{ $category->created_at?->diffForHumans() ?? "null" }}</td>
                <td class="px-6 py-4">
                    <button type="button" data-id="{{ $category->id }}" data-context="0" class="status-active-{{ $category->id }}  active {{ !$category->status ? 'none' : '' }} status text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Active</button>
                    <button type="button" data-id="{{ $category->id }}" data-context="1" class="status-inactive-{{ $category->id }}  inactive {{ $category->status ? 'none' : '' }} status text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Inactive</button>
                </td>
                <td class="px-6 py-4">
                    <button type="button" data-id="{{ $category->id }}" data-context="1" class="update-category focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Update</button>
                    <button type="button" data-id="{{ $category->id }}" data-context="0" class="delete-category focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="container mx-auto mt-3">
        {{ $categories->links() }}
    </div>
</div>

        </section>
    </main>
    @push("scripts")
        <script>
            const deleteCategory = document.querySelectorAll(".delete-category");

            deleteCategory.forEach(deleteCategory => {
                deleteCategory.addEventListener("click", function() {
                    const id = deleteCategory.dataset.id;
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You want to delete this category?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                        if (result.isConfirmed) {
                           axios.delete(`/admin/category/${id}/delete`)
                            .then(res => {
                                if(res.data === 1) {
                                    location.reload();
                                }
                            }) 
                            .catch(err => {

                                console.log(err);
                            })
                        }
                        });
                })
            })
        </script>
        <script>
            const update = document.querySelectorAll(".update-category");
            update.forEach(update => {

            update.addEventListener("click", function() {
                const id = update.dataset.id;
                Swal.fire({
  title: "Category Name",
  input: "text",
  inputAttributes: {
    autocapitalize: "off"
  },
  showCancelButton: true,
  confirmButtonText: "Create",
  showLoaderOnConfirm: true,
  allowOutsideClick: () => !Swal.isLoading()
}).then((result) => {
  if (result.isConfirmed) {

    axios.put(`/admin/category/${id}/update`, {
        category: result.value 
    })
        .then(res => {
            console.log(res);
            if(res.data === 1) {
                location.reload();
            }
        })
        .catch(err => {
            console.log(err)
        })
  }
});

            })
        })
            
        </script>
        <script>
            const create = document.querySelector(".create-new");
            create.addEventListener("click", function() {
                Swal.fire({
  title: "Category Name",
  input: "text",
  inputAttributes: {
    autocapitalize: "off"
  },
  showCancelButton: true,
  confirmButtonText: "Create",
  showLoaderOnConfirm: true,
  allowOutsideClick: () => !Swal.isLoading()
}).then((result) => {
  if (result.isConfirmed) {
    axios.post("{{ route('admin.category.create') }}", {
        category: result.value
    })
        .then(res => {
            if(res.data === 1) {
                location.reload();
            }
        })
        .catch(err => {
            console.log(err)
        })
  }
});
            })
        </script>
        <script>
            
            const statusButtons = document.querySelectorAll(".status");
            
            statusButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const context = button.dataset.context;
                    const category_id = button.dataset.id;
                    const mapper = {
                        0: "inactive",
                        1:  "active"
                    };

                    axios.put(`/admin/category/${category_id}/status`, {
                        context 
                    })
                        .then(res => {
                            const alt_button = document.querySelector(`.status-${mapper[context]}-${category_id}`);
                            button.classList.add("none");
                            alt_button.classList.remove("none");
                        })
                        .catch(err => {
                            console.log(err)
                        })
                });
            })


        </script>
        <script>
            const buttons = document.querySelectorAll(".ban-button");
            
            buttons.forEach(button => {
                button.addEventListener("click", function() {
                    const mapper = {
                        1: "unban",
                        0: "ban"
                    }
                    axios.put(`/admin/user/${button.dataset.id}/ban`, {
                        context: button.dataset.context
                    })
                        .then(res => {
                            button.classList.add("none");
                            const btn = document.querySelector(`.${mapper[button.dataset.context]}-${button.dataset.id}`)
                            btn.classList.remove("none");
                        })
                        .catch(err => {
                            console.log(err)
                        })
                })
            })
        </script>
    @endpush
</x-layout>