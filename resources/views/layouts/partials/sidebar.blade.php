{{-- Overlay untuk layar kecil --}}
<div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-black/30 lg:hidden" data-sidebar-close></div>

<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-brand-800 transition-transform duration-200 lg:static lg:translate-x-0">

    {{-- Brand --}}
    <div class="flex h-16 items-center gap-3 border-b border-white/10 px-5">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-brand-700">
            <i data-lucide="shield-check" class="h-5 w-5"></i>
        </div>
        <p class="text-[13px] font-bold leading-tight text-white">{{ config('app.name') }}</p>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5">
        <div class="space-y-1">
            <x-sidebar.link route="dashboard" icon="layout-dashboard">Dashboard</x-sidebar.link>
        </div>

        @if (auth()->user()->isAdmin())
            <div>
                <x-sidebar.heading>Data Master</x-sidebar.heading>
                <div class="space-y-1">
                    <x-sidebar.link route="master.domain.index" active="master.domain.*" icon="layers">Domain</x-sidebar.link>
                    <x-sidebar.link route="master.proses.index" active="master.proses.*" icon="workflow">Proses TI</x-sidebar.link>
                    <x-sidebar.link route="master.praktik.index" active="master.praktik.*" icon="list-tree">Praktik</x-sidebar.link>
                    <x-sidebar.link route="master.pertanyaan.index" active="master.pertanyaan.*" icon="clipboard-list">Pertanyaan</x-sidebar.link>
                    <x-sidebar.link route="master.pengguna.index" active="master.pengguna.*" icon="users">Pengguna</x-sidebar.link>
                </div>
            </div>

            <div>
                <x-sidebar.heading>Audit</x-sidebar.heading>
                <div class="space-y-1">
                    <x-sidebar.link route="audit.index" active="audit.*,laporan.*" icon="folder-kanban">Proyek Audit</x-sidebar.link>
                </div>
            </div>
        @endif

        @if (auth()->user()->isAsesor())
            <div>
                <x-sidebar.heading>Asesmen</x-sidebar.heading>
                <div class="space-y-1">
                    <x-sidebar.link route="penilaian.index" active="penilaian.*,laporan.*" icon="clipboard-check">Penilaian</x-sidebar.link>
                </div>
            </div>
        @endif

        <div>
            <x-sidebar.heading>Akun</x-sidebar.heading>
            <div class="space-y-1">
                <x-sidebar.link route="profil.edit" icon="user-round">Profil Saya</x-sidebar.link>

                {{-- Keluar: tepat di bawah menu Profil Saya --}}
                <form method="POST" action="{{ route('logout') }}"
                      data-confirm="Keluar dari sistem?"
                      data-confirm-text="Anda perlu login kembali untuk mengakses sistem."
                      data-confirm-button="Ya, keluar">
                    @csrf
                    <button type="submit"
                            class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-brand-100 transition-colors hover:bg-red-500/20 hover:text-white">
                        <i data-lucide="log-out" class="h-4 w-4 shrink-0"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</aside>
