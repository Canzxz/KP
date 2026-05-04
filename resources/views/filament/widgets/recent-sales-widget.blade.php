<x-filament-widgets::widget>
    <div class="recent-sales-root">
        <div class="recent-sales-container">
            {{-- Header --}}
            <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:1.25rem;">
                <div class="recent-sales-accent-bar"></div>
                <h2 class="recent-sales-title">
                    Penjualan Terakhir
                </h2>
            </div>

            {{-- List Item --}}
            <div style="display:flex; flex-direction:column; gap:0.5rem;">
                @forelse ($this->getRecentSales() as $sale)
                    <div class="recent-sales-item">
                        <div style="display:flex; align-items:center; gap:0.75rem;">
                            {{-- Avatar --}}
                            <div class="recent-sales-avatar">
                                {{ strtoupper(substr(optional($sale->kasir)->name ?? 'K', 0, 2)) }}
                            </div>
                            <div>
                                <p class="recent-sales-code">
                                    {{ $sale->kode_transaksi }}
                                </p>
                                <p class="recent-sales-meta">
                                    @if($sale->items->isNotEmpty())
                                        {{ $sale->items->first()->produk->nama_produk ?? '-' }}
                                        @if($sale->items->count() > 1)
                                            <span style="color:#64748b;">(+{{ $sale->items->count() - 1 }} lainnya)</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                        <p class="recent-sales-amount">
                            +Rp {{ number_format($sale->total, 0, ',', '.') }}
                        </p>
                    </div>
                @empty
                    <p style="font-size:0.85rem; color:#475569; text-align:center; padding:1rem 0;">Belum ada transaksi</p>
                @endforelse
            </div>
        </div>

        <style>
            .recent-sales-container {
                background: #ffffff;
                border: 1px solid #cbd5e1;
                border-radius: 1rem;
                padding: 1.5rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }
            .dark .recent-sales-container {
                background: linear-gradient(135deg, #0d1b35 0%, #0f1f3d 100%);
                border: 1px solid rgba(59, 130, 246, 0.15);
                box-shadow: 0 4px 24px -4px rgba(0,0,0,0.5);
            }
            .recent-sales-accent-bar {
                width: 3px;
                height: 1.25rem;
                background: linear-gradient(180deg, #3b82f6, #1d4ed8);
                border-radius: 9999px;
            }
            .recent-sales-title {
                font-size: 1rem;
                font-weight: 700;
                color: #1e293b;
                letter-spacing: -0.02em;
            }
            .dark .recent-sales-title {
                color: white;
            }
            .recent-sales-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: rgba(0,0,0,0.02);
                border: 1px solid rgba(0,0,0,0.05);
                border-radius: 0.625rem;
                padding: 0.7rem 1rem;
            }
            .dark .recent-sales-item {
                background: rgba(255,255,255,0.03);
                border: 1px solid rgba(255,255,255,0.05);
            }
            .recent-sales-avatar {
                width: 2.25rem;
                height: 2.25rem;
                background: linear-gradient(135deg, #1e40af, #3b82f6);
                border-radius: 0.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.7rem;
                font-weight: 800;
                color: white;
                flex-shrink: 0;
            }
            .recent-sales-code {
                font-size: 0.82rem;
                font-weight: 600;
                color: #1e293b;
                line-height: 1.2;
            }
            .dark .recent-sales-code {
                color: white;
            }
            .recent-sales-meta {
                font-size: 0.72rem;
                color: #64748b;
                margin-top: 0.1rem;
            }
            .recent-sales-amount {
                font-size: 0.85rem;
                font-weight: 700;
                color: #059669; /* emerald 600 */
                white-space: nowrap;
                margin-left: 1rem;
            }
            .dark .recent-sales-amount {
                color: #34d399; /* emerald 400 */
            }
        </style>
    </div>
</x-filament-widgets::widget>
