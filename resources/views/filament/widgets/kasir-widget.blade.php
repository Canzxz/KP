<x-filament-widgets::widget>
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold text-white">Sistem Kasir</h2>
                <p class="text-xs text-slate-400">Buat transaksi baru</p>
            </div>
            <a href="{{ url('/admin/transaksi/create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#1152d4] text-white text-sm font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Transaksi Baru
            </a>
        </div>

        <div class="bg-[#1e2433] rounded-xl p-4 border border-[rgba(255,255,255,0.05)]">
            @livewire(
                \App\Filament\Resources\TransaksiResource\Pages\CreateTransaksi::class
            )
        </div>
    </div>
</x-filament-widgets::widget>


