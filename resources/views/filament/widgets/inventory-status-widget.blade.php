<x-filament-widgets::widget>
    <div class="inventory-widget-root">
        <div class="inventory-container">
            {{-- Header --}}
            <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:1.25rem;">
                <div class="inventory-accent-bar"></div>
                <h2 class="inventory-title">
                    Status Inventaris
                </h2>
            </div>

            {{-- List Item --}}
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                @forelse ($this->getInventoryData() as $produk)
                    @php
                        $maxStok = 100;
                        $persen = min(($produk->stok / $maxStok) * 100, 100);
                        if ($produk->stok == 0) {
                            $status = 'Habis';
                            $statusColor = '#ef4444';
                            $barColor = 'linear-gradient(90deg, #ef4444, #dc2626)';
                            $badgeBg = 'rgba(239,68,68,0.1)';
                        } elseif ($produk->stok < 5) {
                            $status = 'Kritis: ' . $produk->stok . ' tersisa';
                            $statusColor = '#ef4444';
                            $barColor = 'linear-gradient(90deg, #ef4444, #dc2626)';
                            $badgeBg = 'rgba(239,68,68,0.1)';
                        } elseif ($produk->stok < 15) {
                            $status = 'Menipis: ' . $produk->stok . ' tersisa';
                            $statusColor = '#f97316';
                            $barColor = 'linear-gradient(90deg, #f97316, #ea580c)';
                            $badgeBg = 'rgba(249,115,22,0.1)';
                        } else {
                            $status = 'Aman: ' . $produk->stok . ' tersisa';
                            $statusColor = '#10b981';
                            $barColor = 'linear-gradient(90deg, #10b981, #059669)';
                            $badgeBg = 'rgba(16,185,129,0.1)';
                        }
                    @endphp

                    <div class="inventory-item">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem;">
                            <p class="inventory-item-name">{{ $produk->nama_produk }}</p>
                            <span style="
                                font-size:0.7rem; font-weight:700;
                                color:{{ $statusColor }};
                                background:{{ $badgeBg }};
                                border:1px solid {{ $statusColor }}40;
                                padding:0.2rem 0.6rem;
                                border-radius:9999px;
                            ">{{ $status }}</span>
                        </div>
                        {{-- Progress Bar --}}
                        <div class="inventory-progress-track">
                            <div style="
                                height:100%;
                                width:{{ $persen }}%;
                                background: {{ $barColor }};
                                border-radius:9999px;
                                transition: width 0.4s ease;
                            "></div>
                        </div>
                    </div>
                @empty
                    <p style="font-size:0.85rem; color:#475569; text-align:center; padding:1rem 0;">Belum ada produk</p>
                @endforelse
            </div>
        </div>

        <style>
            .inventory-container {
                background: #ffffff;
                border: 1px solid #cbd5e1;
                border-radius: 1rem;
                padding: 1.5rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }
            .dark .inventory-container {
                background: linear-gradient(135deg, #0d1b35 0%, #0f1f3d 100%);
                border: 1px solid rgba(59, 130, 246, 0.15);
                box-shadow: 0 4px 24px -4px rgba(0,0,0,0.5);
            }
            .inventory-accent-bar {
                width: 3px;
                height: 1.25rem;
                background: linear-gradient(180deg, #f59e0b, #d97706);
                border-radius: 9999px;
            }
            .inventory-title {
                font-size: 1rem;
                font-weight: 700;
                color: #1e293b;
                letter-spacing: -0.02em;
            }
            .dark .inventory-title {
                color: white;
            }
            .inventory-item {
                background: rgba(0,0,0,0.02);
                border: 1px solid rgba(0,0,0,0.05);
                border-radius: 0.625rem;
                padding: 0.75rem 1rem;
            }
            .dark .inventory-item {
                background: rgba(255,255,255,0.03);
                border: 1px solid rgba(255,255,255,0.05);
            }
            .inventory-item-name {
                font-size: 0.84rem;
                font-weight: 600;
                color: #1e293b;
            }
            .dark .inventory-item-name {
                color: white;
            }
            .inventory-progress-track {
                height: 4px;
                background: rgba(0,0,0,0.06);
                border-radius: 9999px;
                overflow: hidden;
            }
            .dark .inventory-progress-track {
                background: rgba(255,255,255,0.06);
            }
        </style>
    </div>
</x-filament-widgets::widget>
