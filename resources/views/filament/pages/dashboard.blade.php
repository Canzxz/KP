<x-filament-panels::page>

    {{-- Stats Overview --}}
    @livewire(\App\Filament\Widgets\DashboardStatsOverview::class)

    <div class="flex flex-col xl:flex-row gap-6 items-start mt-2">
        {{-- Kiri: Kasir --}}
        <div class="{{ auth()->user()->role === 'kasir' ? 'w-full' : 'w-full xl:w-8/12' }} flex-shrink-0">
            @livewire(\App\Filament\Widgets\KasirWidget::class)
        </div>

        @if(auth()->user()->role !== 'kasir')
        {{-- Kanan: Sidebar Widgets --}}
        <div class="w-full xl:w-4/12 flex flex-col gap-6" id="right-sidebar-widgets">
            <style>
                /* Paksa grafik Filament bawaan agar mirip dengan widget custom kita */
                #right-sidebar-widgets > div:first-child section.fi-section {
                    background: linear-gradient(135deg, #0d1b35 0%, #0f1f3d 100%) !important;
                    border: 1px solid rgba(59, 130, 246, 0.15) !important;
                    border-radius: 1rem !important;
                    box-shadow: 0 4px 24px -4px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.04) !important;
                }
                /* Garis pemisah header grafik */
                #right-sidebar-widgets > div:first-child header.fi-section-header {
                    border-bottom: 1px solid rgba(59, 130, 246, 0.15) !important;
                    padding-bottom: 0.75rem !important;
                }
            </style>
            @livewire(\App\Filament\Widgets\TransaksiChart::class)
            @livewire(\App\Filament\Widgets\RecentSalesWidget::class)
            @livewire(\App\Filament\Widgets\InventoryStatusWidget::class)
        </div>
        @endif
    </div>


</x-filament-panels::page>
