<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SehatMate - Platform Nutrisi Harian')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#22c55e',
                        secondary: '#16a34a',
                        accent: '#15803d'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        .hero-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><rect fill="%23228B22" width="100%" height="100%"/><circle cx="200" cy="150" r="80" fill="%23FFD700" opacity="0.3"/><circle cx="400" cy="300" r="60" fill="%23FF6347" opacity="0.4"/><circle cx="800" cy="200" r="70" fill="%23FFA500" opacity="0.3"/><circle cx="1000" cy="400" r="90" fill="%23FF4500" opacity="0.4"/><circle cx="600" cy="500" r="50" fill="%2332CD32" opacity="0.3"/></svg>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50">
    @yield('content')

    @yield('scripts')
</body>
</html>
