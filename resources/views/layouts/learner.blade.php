<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SisuKai</title>
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #696cff;
            --secondary-color: #8592a3;
            --success-color: #71dd37;
            --danger-color: #ff3e1d;
            --warning-color: #ffab00;
            --info-color: #03c3ec;
            --light-bg: #f5f5f9;
            --card-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
        }
        
        body {
            font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--light-bg);
            font-size: 0.9375rem;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #fff;
            box-shadow: 0 0 1.25rem rgba(75, 70, 92, 0.1);
            z-index: 1050;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        
        .sidebar-brand {
            padding: 1.5rem 1.5rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .sidebar-brand h4 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .menu-header {
            padding: 0.75rem 1.5rem 0.375rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #a1acb8;
            font-weight: 600;
        }
        
        .menu-item {
            margin: 0.125rem 0.75rem;
        }
        
        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.625rem 1rem;
            color: #697a8d;
            text-decoration: none;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            font-weight: 400;
        }
        
        .menu-link:hover {
            background-color: rgba(105, 108, 255, 0.08);
            color: var(--primary-color);
        }
        
        .menu-link.active {
            background-color: rgba(105, 108, 255, 0.16);
            color: var(--primary-color);
            font-weight: 500;
            box-shadow: 0 2px 4px 0 rgba(105, 108, 255, 0.4);
        }
        
        .menu-icon {
            margin-right: 0.75rem;
            font-size: 1.125rem;
            width: 1.375rem;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        /* Navbar */
        .top-navbar {
            background: #fff;
            padding: 0.75rem 1.5rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
        }
        
        .navbar-search {
            max-width: 400px;
        }
        
        .navbar-search .form-control {
            border: 1px solid #d9dee3;
            border-radius: 0.375rem;
            padding: 0.4375rem 1rem;
            font-size: 0.9375rem;
        }
        
        .navbar-search .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
        }
        
        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            background: transparent;
            border: none;
            color: #697a8d;
        }
        
        .user-dropdown .dropdown-toggle:hover {
            color: var(--primary-color);
        }
        
        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, #5f61e6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 0.5rem;
        }
        
        /* Content Container */
        .content-wrapper {
            padding: 0 1.5rem 1.5rem;
        }
        
        /* Cards */
        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid #f0f0f0;
            padding: 1.25rem 1.5rem;
            font-weight: 500;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Stats Cards */
        .stats-card {
            position: relative;
            overflow: hidden;
        }
        
        .stats-card .card-body {
            padding: 1.25rem 1.5rem;
        }
        
        .stats-icon {
            width: 42px;
            height: 42px;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }
        
        .stats-icon.primary {
            background: rgba(105, 108, 255, 0.16);
            color: var(--primary-color);
        }
        
        .stats-icon.success {
            background: rgba(113, 221, 55, 0.16);
            color: var(--success-color);
        }
        
        .stats-icon.warning {
            background: rgba(255, 171, 0, 0.16);
            color: var(--warning-color);
        }
        
        .stats-icon.info {
            background: rgba(3, 195, 236, 0.16);
            color: var(--info-color);
        }
        
        .stats-icon.danger {
            background: rgba(255, 62, 29, 0.16);
            color: var(--danger-color);
        }
        
        .stats-title {
            font-size: 0.8125rem;
            color: #697a8d;
            font-weight: 400;
            margin-bottom: 0.25rem;
        }
        
        .stats-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: #566a7f;
            margin-bottom: 0.25rem;
        }
        
        .stats-change {
            font-size: 0.8125rem;
            font-weight: 500;
        }
        
        .stats-change.positive {
            color: var(--success-color);
        }
        
        .stats-change.negative {
            color: var(--danger-color);
        }
        
        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-color) 0%, #5f61e6 100%);
            color: white;
            border-radius: 0.5rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .welcome-banner h4 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .welcome-banner p {
            margin-bottom: 1rem;
            opacity: 0.9;
        }
        
        .welcome-illustration {
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
        }
        
        /* Buttons */
        .btn {
            border-radius: 0.375rem;
            padding: 0.4375rem 1.25rem;
            font-weight: 500;
            font-size: 0.9375rem;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background: #5f61e6;
            border-color: #5f61e6;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #697a8d;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #d9dee3;
            margin-bottom: 1rem;
        }
        
        .empty-state h6 {
            font-size: 1rem;
            font-weight: 500;
            color: #566a7f;
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            font-size: 0.875rem;
            color: #a1acb8;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        /* Badge */
        .badge {
            padding: 0.375rem 0.625rem;
            font-weight: 500;
            font-size: 0.75rem;
        }
        
        /* List Group */
        .list-group-item {
            border: none;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h4>SisuKai</h4>
        </div>
        
        <nav class="sidebar-menu">
            <div class="menu-header">MENU</div>
            
            <div class="menu-item">
                <a href="{{ route('learner.dashboard') }}" class="menu-link {{ request()->routeIs('learner.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door menu-icon"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="{{ route('learner.certifications.index') }}" class="menu-link {{ request()->routeIs('learner.certifications.index') ? 'active' : '' }}">
                    <i class="bi bi-search menu-icon"></i>
                    <span>Browse Certifications</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="{{ route('learner.certifications.my') }}" class="menu-link {{ request()->routeIs('learner.certifications.my') || request()->routeIs('learner.certifications.show') ? 'active' : '' }}">
                    <i class="bi bi-award menu-icon"></i>
                    <span>My Certifications</span>
                </a>
            </div>
            
            <div class="menu-header">EXAMS</div>
            
            <div class="menu-item">
                <a href="{{ route('learner.exams.index') }}" class="menu-link {{ request()->routeIs('learner.exams.index') || request()->routeIs('learner.exams.show') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text menu-icon"></i>
                    <span>My Exams</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="{{ route('learner.exams.history') }}" class="menu-link {{ request()->routeIs('learner.exams.history') ? 'active' : '' }}">
                    <i class="bi bi-clock-history menu-icon"></i>
                    <span>Exam History</span>
                </a>
            </div>
            
            <div class="menu-header">ACCOUNT</div>
            
            <div class="menu-item">
                <a href="{{ route('learner.profile.show') }}" class="menu-link">
                    <i class="bi bi-person menu-icon"></i>
                    <span>Profile</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="#" class="menu-link">
                    <i class="bi bi-gear menu-icon"></i>
                    <span>Settings</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="#" class="menu-link">
                    <i class="bi bi-bell menu-icon"></i>
                    <span>Notifications</span>
                </a>
            </div>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="navbar-search">
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="dropdown user-dropdown">
                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth('learner')->user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ auth('learner')->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('learner.profile.show') }}"><i class="bi bi-person me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-bell me-2"></i> Notifications</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('learner.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>
    
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Chart.js -->
    @vite(['resources/js/charts.js'])
    
    @yield('scripts')
</body>
</html>

