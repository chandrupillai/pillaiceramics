<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | Pillai Ceramics</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --brand-primary: #0081b8;
            --sidebar-bg: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            transition: all 0.3s ease-in-out;
            z-index: 1040;
            overflow-y: auto;
        }

        #sidebar .nav-link {
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            margin: 0.2rem 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        #sidebar .nav-link.active {
            background-color: var(--brand-primary);
        }

        /* Styling for Submenus / Collapsible items */
        #sidebar .collapse .nav-link {
            padding-left: 2.5rem;
            font-size: 0.85rem;
        }

        #main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease-in-out;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .admin-header {
            height: 70px;
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }

        .card-custom {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                margin-left: 0;
            }

            #main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Sidebar Navigation -->
    <aside id="sidebar">
        <div class="d-flex align-items-center justify-content-between p-3 border-bottom border-secondary border-opacity-25">
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
                <span class="fs-4 fw-bold text-white">Pillai<span class="text-info">Ceramics</span></span>
            </a>
            <button class="btn btn-sm text-white d-lg-none" id="sidebarClose"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="px-3 py-3">
            <span class="text-uppercase text-secondary fw-semibold fs-7 px-3">Main Menu</span>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Products Submenu -->
            <!-- Products Submenu -->
<li class="nav-item">
    <a href="#productsSubmenu" data-bs-toggle="collapse" class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.tile-products.*') ? 'active' : '' }}" aria-expanded="{{ request()->routeIs('admin.tile-products.*') ? 'true' : 'false' }}">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-box-seam-fill"></i>
            <span>Products</span>
        </div>
        <i class="bi bi-chevron-down fs-8"></i>
    </a>
    <div class="collapse {{ request()->routeIs('admin.tile-products.*') ? 'show' : '' }}" id="productsSubmenu">
        <ul class="nav flex-column ps-2">
            <li class="nav-item">
                <a href="{{ route('admin.tile-products.index') }}" class="nav-link {{ request()->routeIs('admin.tile-products.index') ? 'active' : '' }}">
                    <i class="bi bi-list-ul"></i>
                    <span>All Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.tile-products.create') }}" class="nav-link {{ request()->routeIs('admin.tile-products.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Add Product</span>
                </a>
            </li>
        </ul>
    </div>
</li>

            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Users Module</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.locations.index') }}" class="nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Locations</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.godowns.index') }}" class="nav-link {{ request()->routeIs('admin.godowns.*') ? 'active' : '' }}">
                    <i class="bi bi-building-fill"></i>
                    <span>Godowns</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.tile-categories.index') }}" class="nav-link {{ request()->routeIs('admin.tile-categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags-fill"></i>
                    <span>Tile Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.tile-types.index') }}" class="nav-link {{ request()->routeIs('admin.tile-types.*') ? 'active' : '' }}">
                    <i class="bi bi-layers-fill"></i>
                    <span>Tile Types</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.tile-sizes.index') }}" class="nav-link {{ request()->routeIs('admin.tile-sizes.*') ? 'active' : '' }}">
                    <i class="bi bi-aspect-ratio-fill"></i>
                    <span>Tile Sizes</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content Wrapper -->
    <div id="main-content">

        <!-- Header -->
        <header class="admin-header d-flex align-items-center justify-content-between px-4 sticky-top">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light border d-lg-none" id="sidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h5 class="mb-0 fw-bold d-none d-sm-block">Admin Portal</h5>
            </div>

            <!-- Profile & Logout Dropdown -->
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                        </div>
                        <div class="d-none d-md-block text-start">
                            <div class="fw-bold fs-7 mb-0">{{ Auth::user()->name ?? 'Admin User' }}</div>
                            <small class="text-muted fs-8">{{ strtoupper(Auth::user()->role ?? 'ADMIN') }}</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST" id="logout-form">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger border-0 bg-transparent">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Dynamic Body Content -->
        <main class="p-4 flex-grow-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-top py-3 px-4 text-center text-muted fs-7">
            &copy; {{ date('Y') }} Pillai Ceramics. All Rights Reserved.
        </footer>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => sidebar.classList.add('active'));
        }
        if (closeBtn) {
            closeBtn.addEventListener('click', () => sidebar.classList.remove('active'));
        }
    </script>
    @stack('scripts')
</body>

</html>