<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Leartunity</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset("css/output.css") }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://kit.fontawesome.com/3a7e8b6e65.js" crossorigin="anonymous"></script>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet"> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet"> -->

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
      <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
      <script src="http://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}">
 @vite('resources/js/app.js')
   @php

   $settings = \App\Models\Setting::first();
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
        --family: {!! $family !!}
      }
      :root {
        --secondary: {{ $secondary_color }}
      }
    </style>
    <!-- @inertiaHead -->
  </head>
  <body>
    @inertia


    <script src="{{ asset('js/accordion.js') }}"></script>

    <script src="{{ asset("js/transition.js") }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js" integrity="sha512-PJa3oQSLWRB7wHZ7GQ/g+qyv6r4mbuhmiDb8BjSFZ8NZ2a42oTtAq5n0ucWAwcQDlikAtkub+tPVCw4np27WCg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      const changeLocale = el => {
        axios.post("/changeLocale", {
          locale: el.value
        })
          .then(res => {
            location.reload();
          })
          .catch(err => {
            console.log(err)
          })
      }
    </script>
    <script>
      const changeCurrency = element => {
        axios.post("/user/{{ auth()->id() }}/changeCurrency", {
          currency: element.value
        }).then(res => {
          if(res.data === 1) {
            location.reload();
          }
        })
        .catch(err => {
          console.log(err);
        })
      }
    </script>
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
        const changeVisibility = element => {
            const id = element.id.split("-")[1];
            console.log(id);
            axios.put(`/instructor/course/${id}/status`)
              .then(res => {
                console.log(res)
              })
              .catch(err => {
                console.log(err)
              })
        }
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
