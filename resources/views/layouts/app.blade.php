<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Belediye360') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --navy-900: #0a2540;
                --navy-700: #123a63;
                --blue-600: #1e5fbf;
                --slate-50: #f5f7fa;
                --slate-200: #e3e8ef;
                --slate-500: #64748b;
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--slate-50);
                color: #1e2532;
            }

            /* --- Sidebar --- */
            .sidebar {
                width: 240px;
                background: var(--navy-900);
                min-height: 100vh;
                position: fixed;
                top: 0; left: 0;
                display: flex;
                flex-direction: column;
            }
            .sidebar-brand {
                color: #fff;
                font-weight: 800;
                font-size: 1.1rem;
                padding: 1.3rem 1.25rem;
                letter-spacing: -0.3px;
                border-bottom: 1px solid rgba(255,255,255,0.08);
            }
            .sidebar-nav { padding: 1rem 0.75rem; flex: 1; }
            .sidebar-nav .nav-link {
                color: #b9c6da;
                font-size: 0.92rem;
                font-weight: 500;
                padding: 0.6rem 0.9rem;
                border-radius: 0.5rem;
                margin-bottom: 0.15rem;
                display: flex;
                align-items: center;
            }
            .sidebar-nav .nav-link i { margin-right: 0.6rem; font-size: 1rem; width: 18px; }
            .sidebar-nav .nav-link:hover { background: var(--navy-700); color: #fff; }
            .sidebar-nav .nav-link.active { background: var(--blue-600); color: #fff; }
            .sidebar-foot { padding: 1rem 1.25rem; border-top: 1px solid rgba(255,255,255,0.08); }

            /* --- Main area --- */
            .main-area { margin-left: 240px; }
            .topbar {
                background: #fff;
                border-bottom: 1px solid var(--slate-200);
                padding: 1rem 1.75rem;
            }
            .content-area { padding: 1.75rem; }

            /* --- Consistent card/table look, applies everywhere automatically --- */
            .card {
                border: 1px solid var(--slate-200);
                box-shadow: none;
                border-radius: 0.75rem;
            }
            .table thead th {
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--slate-500);
                border-bottom-width: 1px;
            }
            .btn-primary {
                background-color: var(--blue-600);
                border-color: var(--blue-600);
            }
            .btn-primary:hover {
                background-color: var(--navy-700);
                border-color: var(--navy-700);
            }
            .badge { font-weight: 600; font-size: 0.75rem; }
        </style>
    </head>
    <body>
        <div class="sidebar">
            <a href="{{ route('dashboard') }}" class="sidebar-brand text-decoration-none">
                <i class="bi bi-buildings-fill me-1"></i> Belediye360
            </a>

            <nav class="sidebar-nav">
                @auth
                    @unless (auth()->user()->isStaff())
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i> Panel
                        </a>
                    @endunless

                    <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                        <i class="bi bi-list-task"></i> Görevler
                    </a>

                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.departments.index') }}" class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                            <i class="bi bi-diagram-3"></i> Müdürlükler
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Personel
                        </a>
                    @endif
                @endauth
            </nav>

            @auth
                <div class="sidebar-foot">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" style="color: #fff;">
                            <i class="bi bi-person-circle me-2"></i>
                            <div>
                                <div class="small fw-semibold">{{ auth()->user()->name }}</div>
                                <div class="small" style="color: #8fa3bf; font-size: 0.72rem;">{{ auth()->user()->role->label() }}</div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
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
                    </div>
                </div>
            @endauth
        </div>

        <div class="main-area">
            @isset($header)
                <div class="topbar">
                    <div class="fw-bold fs-5" style="color: var(--navy-900);">{{ $header }}</div>
                </div>
            @endisset

            <div class="content-area">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
                {{ $slot }}
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>