<x-filament-panels::page>

    {{-- Header Widgets (Stats) --}}
    @if ($this->getHeaderWidgets())
        <x-filament-widgets::widgets
            :widgets="$this->getVisibleHeaderWidgets()"
            :columns="$this->getHeaderWidgetsColumns()"
        />
    @endif

    {{-- Body Widgets (Chart, Recent Sales, Inventory) --}}
    <x-filament-widgets::widgets
        :widgets="$this->getVisibleWidgets()"
        :columns="$this->getColumns()"
    />
</x-filament-panels::page>
