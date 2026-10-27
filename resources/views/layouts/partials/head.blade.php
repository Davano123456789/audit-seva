<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@hasSection('title')@yield('title') · @endif{{ config('app.name') }}</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com/3.4.16"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { sans: ['Inter', 'sans-serif'] },
                colors: {
                    surface: '#f4f7f6',
                    ink: '#1f2a2e',
                    brand: {
                        50: '#ecfdf7', 100: '#d1faec', 200: '#a7f3da', 300: '#6ee7c0',
                        400: '#34d39e', 500: '#10b983', 600: '#059669', 700: '#047857',
                        800: '#065f46', 900: '#064e3b',
                    },
                },
            },
        },
    };
</script>

@stack('styles')
