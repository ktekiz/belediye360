<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-0">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <i class="bi bi-buildings-fill me-1"></i> Belediye360
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Panel
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tasks.*') ? 'active fw-semibold' : '' }}" href="{{ route('tasks.index') }}">
                        <i class="bi bi-list-task me-1"></i> Görevler
                    </a>
                </li>
                @auth
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active fw-semibold' : '' }}" href="{{ route('admin.departments.index') }}">
                                <i class="bi bi-diagram-3 me-1"></i> Müdürlükler
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active fw-semibold' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people me-1"></i> Personel
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                            <span class="badge bg-secondary ms-1">{{ auth()->user()->role->label() }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-gear me-1"></i> Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-1"></i> Çıkış Yap
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>