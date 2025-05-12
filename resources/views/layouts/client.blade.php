<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ' ERP | Client')</title>
    <meta name="description" content="@yield('meta-description', 'Default meta description here')">

    <!-- Bootstrap style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Application Style -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>

<body>
    <!-- Sidebar Overlay (Mobile Only) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container-fluid">
            <!-- Sidebar toggle button -->
            <button class="btn btn-sm btn-outline-secondary me-2" id="toggle-sidebar">
                <i class="bi bi-list"></i>
            </button>

            <!-- Brand Name -->
            <a class="navbar-brand fw-bold d-none d-md-block me-auto" href="/">ClusterWeb</a>

            <!-- Rounded Pill Search Input -->
            <div class="input-group nav-search-bar me-3 w-25">
                <input type="text" class="form-control rounded-start-pill" placeholder="Search..." style="border-right: 0;">
                <button class="btn btn-outline-secondary rounded-end-pill" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <!-- Navbar content -->
            <div class="d-flex justify-content-around mx-4">
                <a class="nav-link mx-2" href="/" title="Home">
                    <i class="bi bi-house-door p-2 rounded-circle shadow"></i>
                </a>

                <a class="nav-link mx-2" href="javascript:void(0);" title="Notifications">
                    <i class="bi bi-bell p-2 rounded-circle shadow"></i>
                </a>

                <a class="nav-link mx-2" href="javascript:void(0);" title="Messages">
                    <i class="bi bi-envelope p-2 rounded-circle shadow"></i>
                </a>
            </div>
            <ul class="list-group py-1">
                <!-- User dropdown -->
                <li class="dropdown bg-light rounded-pill shadow py-1 px-2 list-unstyled">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-none d-sm-inline me-2">John Doe</span>
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="user-avatar rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="bi bi-question-circle me-2"></i> Help</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="bi bi-box-arrow-right me-2"></i> Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar p-3" id="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="javascript:void(0);">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('client.profile')}}">
                    <i class="bi bi-people"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('client.projects')}}">
                    <i class="bi bi-briefcase"></i>
                    <span>Projects</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('client.billing') }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>Billing</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('client.settings') }}">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <main class="main-content">
        @yield('content')
    </main>

    @livewireScripts

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>