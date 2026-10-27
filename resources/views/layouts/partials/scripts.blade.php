<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
<script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js"></script>
<script>
    lucide.createIcons();

    // Buka/tutup sidebar di layar kecil
    (function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        if (!sidebar) return;

        const toggle = (open) => {
            sidebar.classList.toggle('-translate-x-full', !open);
            overlay.classList.toggle('hidden', !open);
        };

        document.querySelectorAll('[data-sidebar-open]').forEach(el => el.addEventListener('click', () => toggle(true)));
        document.querySelectorAll('[data-sidebar-close]').forEach(el => el.addEventListener('click', () => toggle(false)));
    })();

    // Konfirmasi sebelum submit untuk form yang punya atribut data-confirm="Pesan".
    // Opsional: data-confirm-text (keterangan) dan data-confirm-button (teks tombol).
    document.addEventListener('submit', function (event) {
        const form = event.target;
        if (!form.matches('[data-confirm]')) return;

        event.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: form.dataset.confirm,
            text: form.dataset.confirmText || 'Data yang dihapus tidak dapat dikembalikan.',
            showCancelButton: true,
            confirmButtonText: form.dataset.confirmButton || 'Ya, hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            reverseButtons: true,
        }).then(result => {
            if (result.isConfirmed) form.submit();
        });
    });
</script>
