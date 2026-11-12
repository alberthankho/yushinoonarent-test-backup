<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Filament\Resources\StoreResource\RelationManagers;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;


class StoreResource extends Resource
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
    
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->label('Event Name (Format: Nama - Tanggal (Lokasi))')
                ->maxLength(255)
                ->columnSpanFull(),
            Forms\Components\Toggle::make('is_special')
            ->label('Special Store (Custom DP Enabled)')
            ->helperText('If enabled, you can set custom DP amounts for products in the Products tab.')
            ->live()
            ->afterStateUpdated(function ($record, $state) {
                // Only trigger this if we are on an existing record (Edit page)
                if ($record) {
                    $record->update(['is_special' => $state]);
                }
            }),

            // Textarea::make('description')
            //     ->nullable()
            //     ->label('Status (Format: Passed / Full Slot / etc.)')
            //     ->columnSpanFull(),

            // Forms\Components\Toggle::make('is_open')
            //     ->required(),

          
        ]);
                
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                ->searchable(),

                
                
                // Tables\Columns\TextColumn::make('description')
                // ->searchable(),
                
                // Tables\Columns\IconColumn::make('is_open')
                //     ->boolean()
                //     ->trueColor('success')
                //     ->falseColor('danger')
                //     ->trueIcon('heroicon-o-check-circle')
                //     ->falseIcon('heroicon-o-x-circle')
                //     ->label('Buka?'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        // Set a default placeholder value for 'address' if it's not provided
        $data['address'] = $data['address'] ?? 'No address provided';
    
        // Set a default placeholder path for 'thumbnail' if it's not provided
        $data['thumbnail'] = $data['thumbnail'] ?? 'store-thumbnails/default-placeholder.png';
    
        return $data;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}
