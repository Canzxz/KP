<x-filament-widgets::widget>
    <div class="glass-card p-6">
        <h2 class="text-lg font-bold text-white mb-4">Penjualan Terakhir</h2>
        <div class="space-y-0">
            @forelse ($this->getRecentSales() as $sale)
                <div class="recent-sale-item">
                    <div class="flex items-center gap-3">
                        <div class="sale-avatar">
                            {{ strtoupper(substr(optional($sale->kasir)->name ?? 'K', 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">
                                {{ $sale->kode_transaksi }}
                            </p>
                            <p class="text-xs text-slate-400">
                                @if($sale->items->isNotEmpty())
                                    {{ $sale->items->first()->produk->nama_produk ?? '-' }}
                                    @if($sale->items->count() > 1)
                                        (+{{ $sale->items->count() - 1 }} lainnya)
                                    @endif
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    <p class="text-sm font-bold text-green-400">
                        + Rp {{ number_format($sale->total, 0, ',', '.') }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-slate-500 text-center py-4">Belum ada transaksi</p>
            @endforelse
        </div>
    </div>
</x-filament-widgets::widget>


