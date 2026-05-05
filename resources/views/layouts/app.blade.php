<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Admin')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Page-specific CSS --}}
    @stack('styles')
</head>

<body>

    <!-- Mobile Menu Toggle -->
    <button class="menu-toggle" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="layout">
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <i class="fa-solid fa-hotel"></i>
                <span>Hotel</span>
            </div>

            <nav>
                <a href="{{ route('rooms.index') }}" class="nav-link {{ Request::routeIs('rooms.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-bed"></i> Rooms
                </a>

                <a href="{{ route('bookings.index') }}" class="nav-link {{ Request::routeIs('bookings.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i> Bookings
                </a>

                <a href="{{ route('amenities.index') }}" class="nav-link {{ Request::routeIs('amenities.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-list-check"></i> Amenities
                </a>
            </nav>
        </aside>

        <main class="main">
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>

    @stack('scripts')
</body>

</html>