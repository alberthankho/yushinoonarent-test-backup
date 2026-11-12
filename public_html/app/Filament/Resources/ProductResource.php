<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\PhotosRelationManager;
use App\Models\Brand;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;


class ProductResource extends Resource
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
    
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

                Forms\Components\Textarea::make('about')
                ->required()
                ->maxLength(1024),

                Forms\Components\TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('IDR'),
                
                Forms\Components\TextInput::make('stock') // <-- ADD THIS
                ->required()
                ->numeric()
                ->default(0),

                Forms\Components\FileUpload::make('thumbnail')
                ->required()
                ->image()
                ->directory('product-thumbnails'),

                Forms\Components\Select::make('category_id')
                ->required()
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set){
                    $set('brand_id', null);
                }),

                Forms\Components\Select::make('brand_id')
                ->options(function (callable $get) {
                    $categoryId = $get('category_id');
                    if($categoryId){
                        return Brand::whereHas('brandCategories', function ($query) use ($categoryId) {
                            $query->where('category_id', $categoryId);
                        })->pluck('name', 'id');
                    }
                    return [];
                })
                ->searchable()
                ->preload()
                ->required()
                ->label('Brand'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                ->searchable(),

                Tables\Columns\ImageColumn::make('thumbnail'),

                Tables\Columns\TextColumn::make('category.name'),

                Tables\Columns\TextColumn::make('brand.name'),
                Tables\Columns\TextColumn::make('stock') // <-- ADD THIS
                ->numeric()
                ->sortable(),


            ])
            ->filters([
                //
                SelectFilter::make('category_id')
                ->label('Category')
                    ->relationship('category', 'name'),

                SelectFilter::make('brand_id')
                ->label('Brand')
                    ->relationship('brand', 'name'),
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

    public static function getRelations(): array
    {
        return [
            //
            PhotosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
