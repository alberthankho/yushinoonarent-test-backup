<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MerchandiseResource\Pages;
use App\Filament\Resources\MerchandiseResource\RelationManagers;
use App\Models\Merchandise;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;


class MerchandiseResource extends Resource
{
    // -----------------------------------------------------------
    // START: AUTHORIZATION METHODS (Add these to your class)
    // -----------------------------------------------------------

    public static function canViewAny(): bool
    {
        // Allow access if the user is an admin OR a viewer.
        return auth()->user()->isAdmin() || auth()->user()->isViewer();
    }

    public static function canView(Model $record): bool
    {
        // Allow viewing individual records for both admins and viewers.
        return auth()->user()->isAdmin() || auth()->user()->isViewer();
    }

    public static function canCreate(): bool
    {
        // 🛑 RESTRICTED: Only admins can create new records.
        return auth()->user()->isAdmin();
    }

    public static function canEdit(Model $record): bool
    {
        // 🛑 RESTRICTED: Only admins can edit existing records.
        return auth()->user()->isAdmin();
    }

    public static function canDelete(Model $record): bool
    {
        // 🛑 RESTRICTED: Only admins can delete records.
        return auth()->user()->isAdmin();
    }

    public static function canDeleteAny(): bool
    {
        // 🛑 RESTRICTED: Only admins can delete multiple records (bulk actions).
        return auth()->user()->isAdmin();
    }
    
    // -----------------------------------------------------------
    // END: AUTHORIZATION METHODS
    // -----------------------------------------------------------
    
    protected static ?string $model = Merchandise::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    
    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('stock')
                ->required()
                ->numeric()
                ->default(0),
            Forms\Components\TextInput::make('price_per_pcs')
                ->label('Price per Piece')
                ->required()
                ->rule('decimal:0,3') // <-- This allows decimals
                ->prefix('IDR')
                ->default(0),
            DatePicker::make('stock_date')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('stock')
                ->numeric()
                ->sortable(),
            TextColumn::make('price_per_pcs')
                ->money('IDR')
                ->sortable(),
            TextColumn::make('total_price') // This works because of the accessor in the model!
                ->money('IDR')
                ->label('Total Value'),
            TextColumn::make('stock_date')
                ->date()
                ->sortable(),
        ])
        ->headerActions([ // <-- START: Updated Export Action
            Action::make('export')
                ->label('Export Spreadsheet')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function ($livewire) {
                    
                    $fileName = 'merchandise-' . date('Y-m-d') . '.csv'; 

                    return response()->streamDownload(function () use ($livewire) {
                        $file = fopen('php://output', 'w');

                        // 1. Define the headers for your CSV file
                        fputcsv($file, [
                            'ID',
                            'Merchandise Name',
                            'Stock',
                            'Price per Piece',
                            'Total Stock Value',
                            'Stock Date',
                            'Created At',
                        ]);

                        // 2. Loop through your data and add the corresponding values
                        $livewire->getFilteredTableQuery()->chunk(200, function ($merchandises) use ($file) {
                            foreach ($merchandises as $merchandise) {
                                fputcsv($file, [
                                    $merchandise->id,
                                    $merchandise->name,
                                    $merchandise->stock,
                                    $merchandise->price_per_pcs,
                                    $merchandise->total_price, // This uses your accessor
                                    $merchandise->stock_date->format('Y-m-d'),
                                    $merchandise->created_at->format('Y-m-d H:i:s'),
                                ]);
                            }
                        });

                        fclose($file);
                    }, $fileName);
                })
        ]) // <-- END: Updated Export Action
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMerchandises::route('/'),
            'create' => Pages\CreateMerchandise::route('/create'),
            'edit' => Pages\EditMerchandise::route('/{record}/edit'),
        ];
    }
}
