<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vitaguard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        :root {
            --brand: #16324f;
            --brand-accent: #f5a623;
            --text-main: #102030;
        }

        body {
            color: var(--text-main);
            background:
                radial-gradient(circle at top left, rgba(245, 166, 35, 0.12), transparent 32%),
                radial-gradient(circle at top right, rgba(22, 50, 79, 0.12), transparent 26%),
                linear-gradient(180deg, #f7f9fc 0%, #eef3f8 100%);
            min-height: 100vh;
        }

        .app-navbar {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(16, 32, 48, 0.08);
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.2rem;
            height: 2.2rem;
            border-radius: 0.8rem;
            background: linear-gradient(135deg, var(--brand), #2f5d83);
            color: #fff;
            font-weight: 700;
        }

        .surface-card {
            border: 0;
            border-radius: 1.25rem;
            box-shadow: 0 18px 60px rgba(16, 32, 48, 0.08);
        }

        .auth-shell {
            min-height: calc(100vh - 72px);
        }
    </style>
</head>

<body>
@php
    $hardcodedAuth = session('hardcoded_auth');
    $isAuthenticated = auth()->check() || !empty($hardcodedAuth);
    $displayUsername = auth()->check() ? auth()->user()->username : data_get($hardcodedAuth, 'username');
@endphp
<nav class="navbar navbar-expand-lg navbar-light app-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand font-weight-bold d-flex align-items-center" href="{{ url('/') }}">
            <span class="brand-badge mr-2">V</span>
            Vitaguard
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#appNavbar"
            aria-controls="appNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="appNavbar">
            <div class="mr-auto"></div>

            <div class="form-inline my-2 my-lg-0">
                @if (! $isAuthenticated)
                    <a href="{{ route('login') }}" class="btn btn-outline-primary mr-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @else
                    <div class="text-right mr-3 d-none d-md-block">
                        <div class="small text-muted">Masuk sebagai</div>
                        <div class="font-weight-bold">{{ $displayUsername }}</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="mb-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Logout</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</nav>

<main>
    <div class="container py-4 py-lg-5">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show surface-card" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger surface-card" role="alert">
                <strong>Terjadi kesalahan.</strong>
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWUivQq4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
@stack('scripts')
</body>

</html>