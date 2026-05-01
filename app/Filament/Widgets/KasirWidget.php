<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class KasirWidget extends Widget
{
    protected static string $view = 'filament.widgets.kasir-widget';

    protected static ?int $sort = 0;

    protected int | string | array $columnSpan = 'full';

}


