<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        @if (auth()->check())
            <a class="navbar-brand" href="#">User Panel</a>
        @else
            <a class="navbar-brand" href="#">User Login</a>
        @endif
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                @if (auth()->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.add_task') }}">Add Task</a>
                    </li>
                    <li class="nav-item">
                        <form class="nav-link" method="POST" action="{{ route('user.logout') }}">
                            @csrf
                            <button class="btn" type="submit">Logout</button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
