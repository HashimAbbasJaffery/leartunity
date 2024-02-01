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
</head>
<body>
    @if(session()->has("error"))
        <div class="account_not_found animate__animated animate__bounceIn">
            <p>Your account not found in our database</p>
        </div>
    @endif
    <div class="wrapper flex">
        <div class="vector-art">
            <img src="{{ asset('/img/login-img.png') }}" height="450"  class="login-cover" alt="">
        </div>
        <div class="login-form">
            <div class="logo text-center">
                <h1>Leartunity.</h1>
                <p>Let's learn together</p>
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
                    placeholder="Type Email"
                    value="{{ old('email') }}"
                >
                @error("password")
                    <p class="err-message">{{ $message }}</p>
                @enderror
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password"
                    class="@error('password') invalid @enderror"
                    valie="{{ old('password') }}"
                >
                <input type="submit" value="Login" style="cursor:pointer;">
            </form>
            <a href="#"><p>Forgot Password?</p></a>
        </div>
    </div>
    <script>
        const account_not_found = document.querySelector(".account_not_found");
        setTimeout(() =>{
            account_not_found.classList.add("animate__bounceOut");
            account_not_found.classList.remove("animate__bounceIn");
        }, 10000)
    </script>
</body>
</html>