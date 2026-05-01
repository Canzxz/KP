<?php

namespace App\Filament\Pages;

use App\Models\Transaksi;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPenjualan extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $navigationLabel = 'Laporan Penjualan';
    protected static ?int $navigationSort = 98;

    protected static string $view = 'filament.pages.laporan-penjualan';

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'superadmin';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Transaksi::query()->latest())
            ->columns([
                TextColumn::make('kode_transaksi')->label('Kode Trx')->searchable(),
                TextColumn::make('items.produk.nama_produk')
                    ->label('Produk')
                    ->listWithLineBreaks()
                    ->bulleted(),
                TextColumn::make('total')->label('Total')->money('idr', true)->sortable(),
                TextColumn::make('kasir.name')->label('Kasir')->sortable()->searchable(),
                TextColumn::make('created_at')->label('Waktu')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Filter::make('tanggal')
                    ->form([
                        DatePicker::make('dari_tanggal'),
                        DatePicker::make('sampai_tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->defaultPaginationPageOption('all')
            ->actions([])
            ->headerActions([
                Action::make('cetak_pdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->action(fn () => $this->cetakPdf())
            ]);
    }

    public function cetakPdf()
    {
        // Get currently filtered query builder
        $query = $this->getFilteredTableQuery();
        $transaksis = $query->get();
        $totalPendapatan = $transaksis->sum('total');

        $pdf = Pdf::loadView('pdf.laporan-penjualan', [
            'transaksis' => $transaksis,
            'total' => $totalPendapatan,
            'tanggal' => now()->format('d M Y H:i')
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'laporan-penjualan-' . now()->format('Y-m-d') . '.pdf'
        );
    }
}
