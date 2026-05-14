<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🎓 Student Management System</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --bg-light: #f8f9fa;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: #2b2d42;
        }
        #wrapper {
            display: flex;
            width: 100%;
        }
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, #1e1e2d 0%, #151521 100%);
            color: #fff;
            transition: all 0.3s;
            position: fixed;
            z-index: 1000;
        }
        #sidebar .sidebar-header {
            padding: 20px;
            background: rgba(0,0,0,0.1);
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        #sidebar ul.components {
            padding: 20px 0;
        }
        #sidebar ul li a {
            padding: 12px 25px;
            display: block;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: 0.2s;
        }
        #sidebar ul li a:hover, #sidebar ul li.active > a {
            color: #fff;
            background: rgba(255,255,255,0.05);
            border-left: 4px solid var(--primary-color);
        }
        #sidebar ul li a i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }
        .navbar {
            background: #fff;
            border-bottom: 1px solid #e3e6f0;
            padding: 15px 30px;
        }
        .main-content {
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid #f1f1f1;
            padding: 1.25rem;
            font-weight: 600;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
        }
        .stats-card {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .bg-soft-primary { background: rgba(67, 97, 238, 0.1); color: #4361ee; }
        .bg-soft-success { background: rgba(76, 201, 240, 0.1); color: #4cc9f0; }
        .bg-soft-warning { background: rgba(243, 156, 18, 0.1); color: #f39c12; }
        .bg-soft-danger { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
        
        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #1a1a27;
            color: #e1e1e1;
        }
        body.dark-mode .navbar, body.dark-mode .card, body.dark-mode .main-content {
            background-color: #1e1e2d !important;
            color: #e1e1e1;
            border-color: #2b2b40;
        }
        body.dark-mode .card-header, body.dark-mode .table, body.dark-mode .bg-light, body.dark-mode .modal-content {
            background-color: #2b2b40 !important;
            color: #e1e1e1;
            border-color: #3f3f5a;
        }
        body.dark-mode .form-control, body.dark-mode .form-select {
            background-color: #1a1a27;
            border-color: #3f3f5a;
            color: #e1e1e1;
        }
        body.dark-mode .text-muted {
            color: #a1a1a1 !important;
        }
        
        .student-photo-preview {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
        /* Print Styles */
        @media print {
            #sidebar, .navbar, .btn, .alert, #themeToggle {
                display: none !important;
            }
            #content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 0 !important;
            }
            .main-content {
                padding: 0 !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            body {
                background: white !important;
            }
        }
        /* Mobile Responsiveness */
        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
                margin-left: 0;
            }
            #content.active {
                margin-left: var(--sidebar-width);
                width: calc(100% - var(--sidebar-width));
            }
        }
    </style>
</head>
<body class="{{ isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'dark-mode' : '' }}">
    <div id="wrapper">
        @auth
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h4 class="mb-0">🎓 SMS Admin</h4>
            </div>
            <ul class="list-unstyled components">
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                </li>
                <li class="{{ Request::is('students*') ? 'active' : '' }}">
                    <a href="{{ route('students.index') }}"><i class="bi bi-people"></i> Students</a>
                </li>
                <li class="{{ Request::is('teachers*') ? 'active' : '' }}">
                    <a href="{{ route('teachers.index') }}"><i class="bi bi-person-workspace"></i> Teachers</a>
                </li>
                <li class="{{ Request::is('attendance*') ? 'active' : '' }}">
                    <a href="{{ route('attendance.index') }}"><i class="bi bi-calendar-check"></i> Attendance</a>
                </li>
                <li class="{{ Request::is('classes*') ? 'active' : '' }}">
                    <a href="{{ route('classes.index') }}"><i class="bi bi-building"></i> Classes</a>
                </li>
                <li class="{{ Request::is('departments*') ? 'active' : '' }}">
                    <a href="{{ route('departments.index') }}"><i class="bi bi-briefcase"></i> Departments</a>
                </li>
            </ul>
        </nav>
        @endauth

        <!-- Page Content -->
        <div id="content" style="{{ !Auth::check() ? 'width: 100%; margin-left: 0;' : '' }}">
            @auth
            <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-link text-dark">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <div class="ms-auto d-flex align-items-center">
                        <button class="btn btn-link text-dark me-3" id="themeToggle">
                            <i class="bi bi-moon-stars"></i>
                        </button>
                        <span class="me-3 text-muted d-none d-md-inline">Welcome, {{ Auth::user()->name }}</span>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=4361ee&color=fff" alt="User" class="rounded-circle" width="35">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            @endauth

            <main class="main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarCollapse')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });

        // Theme Toggle
        document.getElementById('themeToggle')?.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            const theme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
            document.cookie = "theme=" + theme + ";path=/;max-age=31536000";
            this.querySelector('i').className = theme === 'dark' ? 'bi bi-sun' : 'bi bi-moon-stars';
        });
        
        // Set initial icon
        window.addEventListener('DOMContentLoaded', () => {
            const isDark = document.body.classList.contains('dark-mode');
            const icon = document.querySelector('#themeToggle i');
            if (icon) icon.className = isDark ? 'bi bi-sun' : 'bi bi-moon-stars';
        });
    </script>
</body>
</html>
