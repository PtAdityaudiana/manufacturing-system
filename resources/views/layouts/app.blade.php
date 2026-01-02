<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Manufacturing System')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="navbar">
    <h2>Manufacturing System</h2>
    <div>
        {{ auth()->user()->name }} ({{ auth()->user()->role }})
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button class="btn-danger">Logout</button>
        </form>
    </div>
</header>

<div class="container">
    @yield('content')
</div>

</body>
</html>
