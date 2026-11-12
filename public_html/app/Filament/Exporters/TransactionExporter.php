<?php

namespace App\Filament\Exporters;

use App\Models\Transaction;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TransactionExporter extends Exporter
{
    protected static ?string $model = Transaction::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('trx_id')->label('Transaction ID'),
            ExportColumn::make('name')->label('Tenant Name'),
            ExportColumn::make('email')->label('Tenant Email'),
            ExportColumn::make('phone_number')->label('Phone Number'),
            ExportColumn::make('product.name')->label('Product Name'),
            ExportColumn::make('total_amount')->label('Total Amount'),
            ExportColumn::make('duration')->label('Duration (Days)'),
            ExportColumn::make('is_paid')
                ->label('Payment Status')
                ->formatStateUsing(fn ($state): string => $state ? 'Paid' : 'Not Paid'),
            ExportColumn::make('delivery_type')->label('Delivery'),
            ExportColumn::make('nik')->label('NIK'),
            ExportColumn::make('tenants_address_ktp')->label('KTP Address'),
            ExportColumn::make('guarantor_name')->label('Guarantor'),
            ExportColumn::make('started_at')
                ->label('Start Date')
                ->formatStateUsing(fn ($state) => $state->format('d-m-Y')),
            ExportColumn::make('ended_at')
                ->label('End Date')
                ->formatStateUsing(fn ($state) => $state->format('d-m-Y')),
            ExportColumn::make('created_at')
                ->label('Booking Date')
                ->formatStateUsing(fn ($state) => $state->format('d-m-Y H:i:s')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your transaction export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' have been exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}