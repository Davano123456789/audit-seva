<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.partials.head')
</head>
<body class="h-full bg-surface text-ink antialiased">
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        @yield('content')
    </main>

    @include('layouts.partials.scripts')
    @include('layouts.partials.alerts')
    @stack('scripts')
</body>
</html>
