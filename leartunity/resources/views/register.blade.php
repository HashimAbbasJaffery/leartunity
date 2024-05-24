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
            @if($user)
                <div style="font-family: 'Montserrat', sans-serif; margin-bottom: 20px;" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                You are being referred by <span class="font-medium">{{ $user->name }}</span>
                </div>
            @endif
            <div class="logo text-center">
                <h1>Leartunity.</h1>
                <p>Let's learn together</p>
            </div>
            <form action="{{ route("register") }}" method="POST" style="display: flex; flex-direction: column;">
                @csrf
                @error("name")
                    <p class="err-message">{{ $message }}</p>
                @enderror
                <input type="hidden" value="{{ $user?->id ?? "" }}" name="referral_id">
                <input 
                    id="name" 
                    type="text" 
                    class="@error('name') invalid @enderror" 
                    name="name" 
                    placeholder="Name"
                    value="{{ old('name') }}"
                >
                @error("email")
                    <p class="err-message">{{ $message }}</p>
                @enderror
                <input 
                    id="email" 
                    type="email" 
                    class="@error('email') invalid @enderror" 
                    name="email" 
                    placeholder="Email"
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
                
                @error("password")
                    <p class="err-message">{{ $message }}</p>
                @enderror
                <input 
                    type="password" 
                    name="password_confirmation" 
                    placeholder="Confirm Password"
                    class="@error('password') invalid @enderror"
                    value="{{ old('password') }}"
                >
                <input type="submit" value="Register" style="cursor:pointer;">
            </form>
            <!-- <a href="#"><p>Forgot Password?</p></a> -->
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