<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.partials.head')
</head>
<body class="h-full bg-surface text-ink antialiased">
    <div class="flex h-screen overflow-hidden">

        @include('layouts.partials.sidebar')

        {{-- "relative" agar elemen absolute (mis. radio sr-only) tetap di dalam area scroll ini --}}
        <div class="relative flex flex-1 flex-col min-w-0 overflow-y-auto">
            @include('layouts.partials.topbar')

            <main class="flex-1 px-4 py-6 lg:px-8">
                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    @include('layouts.partials.scripts')
    @include('layouts.partials.alerts')
    @stack('scripts')
</body>
</html>
