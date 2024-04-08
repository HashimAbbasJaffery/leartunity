
@php
  $settings = config()->get("settings");
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Leartunity</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset("css/output.css") }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
        
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
    <script src="https://kit.fontawesome.com/3a7e8b6e65.js" crossorigin="anonymous"></script>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet"> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet"> -->
    <link href="{{ $settings->font_link }}" rel="stylesheet">
    
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
      <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" integrity="sha512-2eMmukTZtvwlfQoG8ztapwAH5fXaQBzaMqdljLopRSA0i6YKM8kBAOrSSykxu9NN9HrtD45lIqfONLII2AFL/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
 @vite('resources/js/app.js')
   @php 
    $primary_color = $settings->primary_color;
    $secondary_color = $settings->secondary_color;
    $family = $settings->font_family;
   @endphp
    <style>
      .container {
        max-width: 1120px !important;
      }
      :root {
        --primary: {{ $primary_color }};
      }
      :root {
        --family: {!! $family !!}}
      }
      :root {
        --secondary: {{ $secondary_color }}
      }
    </style>
</head>
<body >

    <div class="wrapper">
    @if($user && !$user?->hasVerifiedEmail())
    <div id="confirm-email" style="text-align: center;padding: 0px;background: red; color: white;position: fixed; bottom: 0px; z-index: 2; width: 100%; ">
        <p style="padding: 5px;">We have sent you email at <b>{{ auth()?->user()?->email }}</b>, Please verify email before 60 days. Else account might be deleted (Also check Spam)</p>
      </div>
    @endif
              

<!-- Modal toggle -->


          <div class="none notification animate__animated">
              <p class="notification-message"></p>
          </div>
        @if(session()->has("flash"))
          <div class="account_not_found animate__animated animate__bounceIn">
              <p>{{ session()->get("flash") }}</p>
          </div>
        @endif
        <header class="flex top-header  container mx-auto mt-4">
            <div class="logo">
                <a href="{{ route("home") }}"><h1>Leartunity.</h1></a>
            </div>
            <nav>
                <ul style="position: relative;">
                    <!-- <li class="mx-3"><a href="#" class="bold-600">Contact Us</a></li> -->
                    @can("admin")
                      <li ><a href="/admin" class="bold-600 text-xl" style="position: relative; font-size: 14px;">
                        Admin
                      </a></li>
                    @endcan 
                    <!-- <li ><a href="{{ route('logout') }}" class="bold-600 text-xl" style="position: relative; font-size: 14px;">
                      LTS Store
                    </a></li> -->
                    @auth
                      <li class="mx-3"><a href="{{ route("learn") }}" class="bold-600" style="font-size: 14px;">My Learning</a></li>
                    @endauth
                    <!-- <li class="mx-3"><a href="#" class="bold-600">Plans</a></li> -->
                    <li class="mx-3"><a href="{{ route('courseList') }}" style="font-size: 14px;" class="bold-600">Courses</a></li>
                    <!-- <li class="mx-3"><a href="#" class="bold-600">Privacy Policy</a></li> -->
                    @can("teach")
                      <li class="mx-3"><a href="{{ route("instructor") }}" style="font-size: 14px;" class="bold-600">Instructor</a></li>
                    @endcan
                    @auth
                      <li class="mx-3 highlighted"><a style="font-size: 14px;" href="/profile/{{ auth()->user()->id   }}" class="bold-600">{{ !auth()->user() ? "login" : auth()->user()->name }}</a></li>
                    @endauth
                    @guest
                    <li class="mx-3"><a href="{{ route("login") }}" class="bold-600" style="font-size: 14px;">Register</a></li>
                      <li class="mx-3 highlighted"><a href="{{ route("login") }}" class="bold-600" style="font-size: 14px;">Login</a></li>
                    @endguest 
                    
                    @auth 
                    <!-- <li ><a href="#" style="font-size: 20px;" class="bold-600 text-xl" style="position: relative; display: inline-block;">
                      <div class="notify {{ $notifications->exists() ? "" : "none" }}" style="position: absolute; background: #00ff00; width: 10px; height: 10px; border-radius: 50px; border: 3px solid white;">&nbsp;</div>
                      <i class="fa-solid fa-bell"></i>
                    </a></li> -->
                    <ul class="notification-drop" style="position: relative;">
                      <li class="item">
                        <i class="fa fa-bell-o notification-bell" style="font-size: 20px;" aria-hidden="true"></i>  
                        <div class="notify {{ $notifications->exists() ? "" : "none" }}" style="top: 8px; right: 8px;position: absolute; background: #00ff00; width: 15px; height: 15px; border-radius: 50px; border: 3px solid white;">&nbsp;</div>
                                          
                        <ul class="rounded" style="max-height: 300px; overflow: auto; border: 1px solid var(--primary)">
                          @forelse($notifications->get() as $notification)
                            <li style="font-size: 12px;">{{ $notification->data["message"] }}</li>
                          @empty 
                            <li style="font-size: 12px;" class="px-1">No notifications? Maybe they're at a disco party! 🎉</li>
                          @endforelse
                        </ul>
                      </li>
                    </ul>

                      <li ><a href="{{ route('logout') }}" style="font-size: 20px;" class="bold-600 text-xl" style="position: relative;">
                        <i class="fa-solid fa-power-off"></i>
                      </a></li>
                    @endauth

                    @auth
                      <li ><a href="{{ route('logout') }}" class="bold-600 text-xl" style="position: relative; font-size: 14px;">
                        {{ (new \App\Classes\Points())->balance(\App\Models\User::find(auth()->id())) }} LTS
                      </a></li>
                    @endauth
                    
                </ul>
            </nav>
        </header>

        {{ $slot }}

        <footer>
          <div class="container mx-auto flex justify-around">
          <div class="first-column column">
            <h1>Learning Materials</h1>
            <nav>
              <ul>
                <li>courses</li>
                <li>books</li>
                <li>live sessions</li>
                <li>teachers</li>
              </ul>
            </nav>
          </div>
          <div class="second-column column">
            <h1>Website Information</h1>
            <nav>
              <ul>
                <li>privacy policy</li>
                <li>contact us</li>
                <li>feedbacks</li>
              </ul>
            </nav>
          </div>
          <div class="fourth-column column">
            <h1>Newsletter</h1>
            <div class="newsletter">
              <input type="text" />
              <button>Subscribe</button>
            </div>
          </div>
          
          <div class="third-column column">
            <h1>Leartunity.</h1>
          </div>
        </div>
        </footer>
    </div>
    <script src="{{ asset("js/transition.js") }}"></script>
    <script>
      $(document).ready(function() {
        $(".notification-drop .item").on('click',function() {
          {{ \App\Models\User::find(auth()?->id())?->unreadNotifications->markAsRead() }}
          $(this).find('ul').toggle();
        });
      });
    </script>
    <script>
        const switches = document.querySelectorAll(".course-switch");
        switches.forEach(switchItems => {
          switchItems.addEventListener("change", function(e) {
            const target = e.target;
            const id = target.id.split("-")[1];
            axios.put(`/instructor/course/${id}/status`)
              .then(res => {
                console.log(res)
              })
              .catch(err => {
                console.log(err)
              })

          })
        })
        // switches.forEach()
      </script>
    <script>
      const messageAppearence = (message, time) => {
        const messageEl = document.querySelector(".notification-message");
        messageEl.textContent = message;
        const notification = document.querySelector(".notification");
        notification.classList.remove("none");
        notification.classList.add("animate__bounceIn"); 
        setTimeout(() =>{
            notification.classList?.add("animate__bounceOut");
            notification.classList?.remove("animate__bounceIn");
        }, time)
      }
      const playAudio = file => {
        const audio = new Audio(`/audio/${file}`);
        audio.play();
      }
        const account_not_found = document.querySelector(".account_not_found");
        setTimeout(() =>{
            account_not_found.classList.add("animate__bounceOut");
            account_not_found.classList.remove("animate__bounceIn");
        }, 10000);
        
    </script>
    @auth 
      <script>
        window.addEventListener("load", function() {
          Echo.private(`notification.{{ auth()->user()->id }}`)
            .listen('NotificationEvent', (e) => {
                const notify = document.querySelector(".notify");
                notify.classList.remove("none");
                messageAppearence(e.message, 5000);
            });
        })
      </script>

    @endauth
    @stack("scripts")
</body>
</html>