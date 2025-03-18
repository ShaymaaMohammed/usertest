<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{route('users_list')}}">Users</a>
            </li>
        </ul>
        <ul class="navbar-nav">
           
        </ul>
        <ul class="navbar-nav">
            @auth
            <li class="nav-item">
                <a class="nav-link" href=#>{{ auth()->user()->name }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('do_logout')}}">Logout</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{route('login')}}">Login</a>
            </li>
            @endauth
            <li class="nav-item">
                <a class="nav-link" href="{{route('register')}}">Register</a>
            </li>
        </ul>
    </div>
</nav>