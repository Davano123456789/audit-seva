@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <div class="w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-xl md:grid md:grid-cols-2">

        {{-- Panel informasi --}}
        <div class="hidden flex-col justify-between bg-brand-800 p-10 text-white md:flex">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white text-brand-700">
                    <i data-lucide="shield-check" class="h-5 w-5"></i>
                </div>
                <span class="text-sm font-semibold text-brand-100">COBIT 2019</span>
            </div>

            <div>
                <h2 class="text-2xl font-bold leading-snug">{{ config('app.name') }}</h2>
                <p class="mt-3 text-sm text-brand-100">
                    Ukur tingkat kapabilitas proses TI organisasi berdasarkan kerangka kerja COBIT 2019.
                </p>
            </div>

            <p class="text-xs text-brand-200">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
        </div>

        {{-- Form login --}}
        <div class="p-8 sm:p-10">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-ink">Masuk</h1>
                <p class="mt-1 text-sm text-gray-500">Silakan masuk menggunakan akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                               autocomplete="username" placeholder="nama@email.com"
                               @class([
                                   'w-full rounded-lg border py-2.5 pl-10 pr-3 text-sm outline-none transition focus:ring-2',
                                   'border-red-400 focus:border-red-500 focus:ring-red-100' => $errors->has('email'),
                                   'border-gray-300 focus:border-brand-500 focus:ring-brand-100' => ! $errors->has('email'),
                               ])>
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-10 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                        <button type="button" id="toggle-password" aria-label="Tampilkan password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i data-lucide="eye" class="h-4 w-4"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                    Ingat saya
                </label>

                <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-brand-600 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                    <i data-lucide="log-in" class="h-4 w-4"></i>
                    Masuk
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    </script>
@endpush
