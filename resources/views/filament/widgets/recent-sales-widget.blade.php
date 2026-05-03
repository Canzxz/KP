<x-filament-widgets::widget>
    <div style="
        background: linear-gradient(135deg, #0d1b35 0%, #0f1f3d 100%);
        border: 1px solid rgba(59, 130, 246, 0.15);
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 24px -4px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.04);
    ">
        {{-- Header --}}
        <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:1.25rem;">
            <div style="
                width:3px; height:1.25rem;
                background: linear-gradient(180deg, #3b82f6, #1d4ed8);
                border-radius:9999px;
            "></div>
            <h2 style="font-size:1rem; font-weight:700; color:white; letter-spacing:-0.02em;">
                Penjualan Terakhir
            </h2>
        </div>

        {{-- List Item --}}
        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            @forelse ($this->getRecentSales() as $sale)
                <div style="
                    display:flex;
                    align-items:center;
                    justify-content:space-between;
                    background: rgba(255,255,255,0.03);
                    border: 1px solid rgba(255,255,255,0.05);
                    border-radius: 0.625rem;
                    padding: 0.7rem 1rem;
                    transition: background 0.2s;
                ">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        {{-- Avatar --}}
                        <div style="
                            width:2.25rem; height:2.25rem;
                            background: linear-gradient(135deg, #1e40af, #3b82f6);
                            border-radius:0.5rem;
                            display:flex; align-items:center; justify-content:center;
                            font-size:0.7rem; font-weight:800; color:white; flex-shrink:0;
                        ">
                            {{ strtoupper(substr(optional($sale->kasir)->name ?? 'K', 0, 2)) }}
                        </div>
                        <div>
                            <p style="font-size:0.82rem; font-weight:600; color:white; line-height:1.2;">
                                {{ $sale->kode_transaksi }}
                            </p>
                            <p style="font-size:0.72rem; color:#64748b; margin-top:0.1rem;">
                                @if($sale->items->isNotEmpty())
                                    {{ $sale->items->first()->produk->nama_produk ?? '-' }}
                                    @if($sale->items->count() > 1)
                                        <span style="color:#475569;">(+{{ $sale->items->count() - 1 }} lainnya)</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    <p style="font-size:0.85rem; font-weight:700; color:#34d399; white-space:nowrap; margin-left:1rem;">
                        +Rp {{ number_format($sale->total, 0, ',', '.') }}
                    </p>
                </div>
            @empty
                <p style="font-size:0.85rem; color:#475569; text-align:center; padding:1rem 0;">Belum ada transaksi</p>
            @endforelse
        </div>
    </div>
</x-filament-widgets::widget>
