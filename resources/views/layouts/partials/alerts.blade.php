{{-- Notifikasi flash message dari controller: ->with('success'|'error', '...') --}}
@if (session('success') || session('error'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            timer: 3000,
            showConfirmButton: false,
            icon: @json(session('success') ? 'success' : 'error'),
            title: @json(session('success') ?? session('error')),
        });
    </script>
@endif
