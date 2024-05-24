<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leartunity</title>
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
      <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <meta name="google-signin-client_id" content="820977587554-bg7nq86t8ugvisd6hp96c9htc231ko01.apps.googleusercontent.com">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>
<body>
    @if(session()->has("error"))
        <div class="account_not_found animate__animated animate__bounceIn">
            <p>@lang("Your account not found in our database")</p>
        </div>
    @endif
    @if(session()->has("success"))
        <div class="account_not_found animate__animated animate__bounceIn">
            <p>{{ session()->get("success") }}</p>
        </div>
    @endif
    <div class="wrapper flex">
        <div class="vector-art">
            <img src="{{ asset('/img/login-img.png') }}" height="450"  class="login-cover" alt="">
        </div>
        
        <div class="login-form">
            <div class="logo text-center">
                <h1>Leartunity.</h1>
                <p>@lang("Let's learn together")</p>
            </div>
            <form action="{{ route("login") }}" method="POST" style="display: flex; flex-direction: column;">
                @csrf

                @error("email")
                    <p class="err-message">{{ $message }}</p>
                @enderror
                <input 
                    id="email" 
                    type="email" 
                    class="@error('email') invalid @enderror" 
                    name="email" 
                    placeholder="@lang('Type Email')"
                    value="{{ old('email') }}"
                >
                @error("password")
                    <p class="err-message">{{ $message }}</p>
                @enderror
                <input 
                    type="password" 
                    name="password" 
                    placeholder="@lang('Password')"
                    class="@error('password') invalid @enderror"
                    valie="{{ old('password') }}"
                >
                <input type="submit" value="@lang('Login')" style="cursor:pointer;">
                <div class="g-signin2" data-onsuccess="onSignIn"></div>
            </form>
            <a href="{{ route('forgot-password') }}"><p>@lang("Forgot Password?")</p></a>
        </div>
    </div>
    <script>
        const account_not_found = document.querySelector(".account_not_found");
        setTimeout(() =>{
            account_not_found.classList.add("animate__bounceOut");
            account_not_found.classList.remove("animate__bounceIn");
        }, 10000)
    </script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script>
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
            console.log('Name: ' + profile.getName());
            console.log('Image URL: ' + profile.getImageUrl());
            console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
        }
    </script>
</body>
</html>