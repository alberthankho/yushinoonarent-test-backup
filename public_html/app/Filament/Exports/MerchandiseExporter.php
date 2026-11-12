<?php

namespace App\Filament\Exports;

use App\Models\Merchandise;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class MerchandiseExporter extends Exporter
{
    protected static ?string $model = Merchandise::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('name')->label('Merchandise Name'),
            ExportColumn::make('stock')->label('Stock'),
            ExportColumn::make('price_per_pcs')->label('Price per Piece'),
            ExportColumn::make('total_price')->label('Total Stock Value'),
            ExportColumn::make('stock_date')->label('Stock Date'),
            ExportColumn::make('created_at')->label('Created At'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your merchandise export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' have been exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
