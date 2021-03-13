<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-success">
                <a class="navbar-brand text-white" href="/"><i class="fa fa-envelope"></i> Saraha App</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav">
                    {{-- <li class="nav-item active">
                      <a class="nav-link text-white" href="/">Home<span class="sr-only">(current)</span></a>
                    </li> --}}
                    @guest
                        <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}"><i class="fas fa-user"></i> Register</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}"><i class="fas fa-lock"></i> Login</a>
                        </li>
                    @endguest
                    @auth 
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('home') }}"><i class="fas fa-user"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('user.profile') }}"><i class="fas fa-envelope"></i> Your Messages</a>
                        </li>
                    @endauth
                  </ul>
                </div>
            </nav>              
        </header>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h2 class="mt-5">
                            Are you ready to accept criticism?
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h3 class="mt-4">In work</h3>  
                        <ul>
                            <li>Boost your strengths</li>
                            <li>Treat your weakness</li>
                        </ul>
                    </div>
                    <div class="col">
                            <h3 class="mt-4">With Your Friends</h3>  
                        <ul>
                            <li>Strengthen your friendships by knowing your advantages and disadvantages</li>
                            <li>Keep your friends to be honest with you</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        @guest
        <section>
            <div class="container mt-5" style="background-color: rgba(16, 187, 179, 0.11)">
                <div class="row">
                    <div class="col">
                       <h4 class="mt-3 mb-3">1- You Can Create Saraha Account Easily from <a href="{{ route('register') }}">HERE</a></h4><br>
                        Friends and others will write their personal and honest opinion about you at this link
                    </div>

                    <div class="col">
                        <h4 class="mt-3 mb-3">2- You Can Share Your Public profile on Facebook, Twitter, LinkedIn, or Anywhere</h4> <br>
                        The messages you receive are private, No One Except You Can See Them
                    </div>

                    <div class="col">
                        <h4 class="mt-3 mb-3">3- You Can Read What Others Wrote About You!</h4> <br>
                        You Can Share Your Messages Easily
                    </div>

                </div>
            </div>
        </section>
        @endguest
    </body>
</html>