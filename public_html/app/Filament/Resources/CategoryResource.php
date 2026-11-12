<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;


class CategoryResource extends Resource
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
    
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

                Forms\Components\FileUpload::make('icon')
                ->required()
                ->image()
                ->directory('category-icons'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                ->searchable(),

                Tables\Columns\TextColumn::make('slug'),

                Tables\Columns\ImageColumn::make('icon'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
