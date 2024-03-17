<x-layout>
    <main>
    <section id="admin-header" class="my-4 container mx-auto rounded mb-2">
            <ul class="flex justify-center">
                <li>
                    <a class="py-3 px-4 block admin-nav" href="#">
                        <i class="fa-solid fa-gauge"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a class="py-3 px-4 block admin-nav  header-active" href="#">
                        <i class="fa-solid fa-user"></i>
                        Users
                    </a>
                </li>
                <li>
                    <a class="py-3 px-4 block admin-nav" href="#">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        Courses
                    </a>
                </li>
                <li>
                    <a class="py-3 px-4 block admin-nav" href="#">
                        <i class="fa-solid fa-money-bill"></i>
                        Plans
                    </a>
                </li>
                <li>
                    <a class="py-3 px-4 block admin-nav" href="#">
                        <i class="fa-solid fa-list"></i>
                        Categories
                    </a>
                </li>
                <li>
                    <a class="py-3 px-4 block admin-nav" href="#">
                        <i class="fa-solid fa-gear"></i>
                        Settings
                    </a>
                </li>
            </ul>
        </section>
        <section id="users" class="container mx-auto">


<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="search flex justify-end mr-3">
        <form name="q" id="q">
            <input type="text" value="{{ $keyword }}" name="keyword" id="search" style="border-radius: 0px; width: 20%; height: 25px; font-size: 14px; padding-left: 10px;" placeholder="Enter Username">
            <input type="submit" value="Search" style="border-radius: 0px; width: 5%; font-size: 12px; height: 25px; padding: 0px;">
        </form>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    User
                </th>
                <th scope="col" class="px-6 py-3">
                    Role
                </th>
                <th scope="col" class="px-6 py-3">
                    Followers
                </th>
                <th scope="col" class="px-6 py-3">
                    Streak
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Since
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="user flex items-center ">
                            <div class="profile mr-3">
                                <img src="{{ asset($user->profile?->profile_pic ? "profile/" . $user->profile->profile_pic : "https://placehold.co/60x60") }}" height="30" width="30" class="rounded" alt="">
                            </div>
                            <div class="user-detail" style="font-size: 13px;">{{ $user->name }}</div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        {{ $user->role }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $user->follows->count() }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $user->streak }}
                    </td>
                    <td class="px-6 py-4">
                        
                        <!-- @if($user->status)
                            <button type="button" data-id="{{ $user->id }}" data-context="0" class="status text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Active</button>
                        @else
                            <button type="button" data-id="{{ $user->id }}" data-context="1" class="status text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Inactive</button>
                        @endif -->
                        
                        <button type="button" data-id="{{ $user->id }}" data-context="0" class="status-active-{{ $user->id }}  active {{ !$user->status ? 'none' : '' }} status text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Active</button>
                        <button type="button" data-id="{{ $user->id }}" data-context="1" class="status-inactive-{{ $user->id }}  inactive {{ $user->status ? 'none' : '' }} status text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Inactive</button>
                        
                    </td>
                    <td class="px-6 py-4">
                        {{ $user->created_at->diffForHumans() }}
                    </td>
                    <td class="flex items-center px-6 py-4">
                        <!-- @if(!$user->is_ban)
                            <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Ban</button>
                        @else
                            <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Unban</button>
                        @endif -->

                        <button type="button" data-context="1" data-id="{{ $user->id }}" class="ban-{{ $user->id }} ban-button {{ $user->isBanned() ? "none" : "" }} focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Ban</button>
                        <button type="button" data-context="0" data-id="{{ $user->id }}" class="unban-{{ $user->id }} ban-button {{ $user->isNotBanned() ? "none" : "" }} focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Unban</button>
                        
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
    <div class="container mx-auto mt-3">
        {{ $users->links() }}
    </div>
</div>

        </section>
    </main>
    @push("scripts")
        <script>
            
            const statusButtons = document.querySelectorAll(".status");
            
            statusButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const context = button.dataset.context;
                    const user_id = button.dataset.id;
                    const mapper = {
                        0: "inactive",
                        1:  "active"
                    };

                    axios.put(`/admin/user/${user_id}/status`, {
                        context 
                    })
                        .then(res => {
                            const alt_button = document.querySelector(`.status-${mapper[context]}-${user_id}`);
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