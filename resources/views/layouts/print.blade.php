<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.partials.head')
    <style>
        @page { size: A4; margin: 15mm; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .avoid-break { break-inside: avoid; }
        }
    </style>
</head>
<body class="bg-gray-100 text-ink antialiased print:bg-white">
    <div class="no-print sticky top-0 z-10 flex items-center justify-between gap-3 border-b border-gray-200 bg-white px-4 py-3">
        <p class="text-sm text-gray-600">Pratinjau cetak &middot; pilih <strong>Simpan sebagai PDF</strong> untuk membuat file PDF.</p>
        <div class="flex gap-2">
            <button type="button" onclick="window.close()" class="rounded-lg border border-gray-300 px-4 py-2 text-sm">Tutup</button>
            <button type="button" onclick="window.print()" class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-medium text-white hover:bg-brand-700">Cetak</button>
        </div>
    </div>

    <main class="mx-auto my-6 max-w-[210mm] bg-white p-8 shadow print:m-0 print:max-w-none print:p-0 print:shadow-none">
        @yield('content')
    </main>

    <script>
        window.addEventListener('load', () => setTimeout(() => window.print(), 400));
    </script>
</body>
</html>
