<x-filament-widgets::widget>
    <div style="
        background: linear-gradient(135deg, #0d1b35 0%, #0f1f3d 100%);
        border: 1px solid rgba(59, 130, 246, 0.15);
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 24px -4px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.04);
        height: 100%;
    ">
        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
            <div style="display:flex; align-items:center; gap:0.6rem;">
                <div style="
                    width:3px; height:1.25rem;
                    background: linear-gradient(180deg, #3b82f6, #1d4ed8);
                    border-radius:9999px;
                "></div>
                <div>
                    <h2 style="font-size:1.1rem; font-weight:700; color:white; letter-spacing:-0.02em; line-height:1.2;">Sistem Kasir</h2>
                    <p style="font-size:0.75rem; color:#64748b; margin-top:0.1rem;">Buat transaksi baru</p>
                </div>
            </div>
            
            <a href="{{ url('/admin/transaksi/create') }}"
               style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.5rem 1rem; background:linear-gradient(135deg, #2563eb, #1d4ed8); color:white; font-size:0.8rem; font-weight:700; border-radius:0.75rem; text-decoration:none; box-shadow:0 4px 15px -3px rgba(37,99,235,0.5);">
                <svg xmlns="http://www.w3.org/2000/svg" style="height:1rem; width:1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Transaksi Baru
            </a>
        </div>

        <div style="background: rgba(255,255,255,0.02); border-radius:0.75rem; border:1px solid rgba(255,255,255,0.05); padding:1rem;">
            @livewire(
                \App\Filament\Resources\TransaksiResource\Pages\CreateTransaksi::class
            )
        </div>
    </div>
</x-filament-widgets::widget>


