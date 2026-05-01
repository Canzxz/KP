<x-filament-widgets::widget>
    <div class="glass-card p-6">
        <h2 class="text-lg font-bold text-white mb-4">Status Inventaris</h2>
        <div class="space-y-4">
            @forelse ($this->getInventoryData() as $produk)
                @php
                    $maxStok = 100;
                    $persen = min(($produk->stok / $maxStok) * 100, 100);
                    if ($produk->stok == 0) {
                        $status = 'Habis';
                        $statusColor = 'text-red-400';
                        $barClass = 'critical';
                    } elseif ($produk->stok < 5) {
                        $status = 'Kritis: ' . $produk->stok . ' tersisa';
                        $statusColor = 'text-red-400';
                        $barClass = 'critical';
                    } elseif ($produk->stok < 15) {
                        $status = 'Menipis: ' . $produk->stok . ' tersisa';
                        $statusColor = 'text-orange-400';
                        $barClass = 'low';
                    } else {
                        $status = 'Aman: ' . $produk->stok . ' tersisa';
                        $statusColor = 'text-green-400';
                        $barClass = 'good';
                    }
                @endphp
                <div>
                    <div class="flex justify-between mb-1">
                        <p class="text-sm font-semibold text-white">{{ $produk->nama_produk }}</p>
                        <p class="text-xs font-bold {{ $statusColor }}">{{ $status }}</p>
                    </div>
                    <div class="inventory-bar">
                        <div class="inventory-bar-fill {{ $barClass }}" style="width: {{ $persen }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500 text-center py-4">Belum ada produk</p>
            @endforelse
        </div>
    </div>
</x-filament-widgets::widget>


