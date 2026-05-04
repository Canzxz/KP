<x-filament-widgets::widget>
    <div class="kasir-widget-root">
        <div class="kasir-widget-container">
            {{-- Header --}}
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
                <div style="display:flex; align-items:center; gap:0.6rem;">
                    <div class="kasir-accent-bar"></div>
                    <div>
                        <h2 class="kasir-title">Sistem Kasir</h2>
                        <p class="kasir-subtitle">Buat transaksi baru</p>
                    </div>
                </div>
            </div>

            <div class="kasir-form-wrapper">
                @livewire(
                    \App\Filament\Resources\TransaksiResource\Pages\CreateTransaksi::class
                )
            </div>
        </div>

        <style>
            .kasir-widget-container {
                background: #ffffff;
                border: 1px solid #cbd5e1;
                border-radius: 1rem;
                padding: 1.5rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                height: 100%;
                transition: all 0.3s ease;
            }
            .dark .kasir-widget-container {
                background: linear-gradient(135deg, #0d1b35 0%, #0f1f3d 100%);
                border: 1px solid rgba(59, 130, 246, 0.15);
                box-shadow: 0 4px 24px -4px rgba(0,0,0,0.5);
            }
            .kasir-accent-bar {
                width: 3px;
                height: 1.25rem;
                background: linear-gradient(180deg, #3b82f6, #1d4ed8);
                border-radius: 9999px;
            }
            .kasir-title {
                font-size: 1.1rem;
                font-weight: 700;
                color: #1e293b;
                letter-spacing: -0.02em;
                line-height: 1.2;
            }
            .dark .kasir-title {
                color: white;
            }
            .kasir-subtitle {
                font-size: 0.75rem;
                color: #64748b;
                margin-top: 0.1rem;
            }
            .kasir-form-wrapper {
                background: rgba(0,0,0,0.02);
                border-radius: 0.75rem;
                border: 1px solid rgba(0,0,0,0.05);
                padding: 1rem;
            }
            .dark .kasir-form-wrapper {
                background: rgba(255,255,255,0.02);
                border: 1px solid rgba(255,255,255,0.05);
            }
        </style>
    </div>
</x-filament-widgets::widget>
