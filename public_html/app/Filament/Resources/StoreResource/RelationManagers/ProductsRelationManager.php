<?php

namespace App\Filament\Resources\StoreResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\AttachAction;
use App\Models\Product;


class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';
    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            // other product fields if you want create action
        ]);
    }

    public function table(Table $table): Table
    {
       return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Product'),
                Tables\Columns\TextColumn::make('pivot.price')
                    ->label('Price')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('pivot.custom_dp_amount')
                    ->label('Custom DP')
                    ->money('IDR')
                    ->placeholder('Default (200k)')
                    ->visible(fn ($livewire) => $livewire->getOwnerRecord()->is_special),
                Tables\Columns\TextColumn::make('pivot.description')
                    ->label('Description')
                    ->wrap(), // optional: wraps long text
            
                Tables\Columns\IconColumn::make('pivot.is_open')
                    ->label('Is Open')
                    ->boolean(), // renders check/cross icons for true/false
            ])
            ->headerActions([
               AttachAction::make()
                ->preloadRecordSelect()
                ->form(fn (AttachAction $action): array => [
                    $action->getRecordSelect()
                        ->required()
                        ->searchable(),
            
                    Forms\Components\TextInput::make('price')
                        ->numeric()
                        ->required()
                        ->prefix('IDR'),
                        
                    Forms\Components\TextInput::make('custom_dp_amount')
                        ->numeric()
                        ->label('Custom DP Amount')
                        ->prefix('IDR')
                        ->helperText('Only used if the Store is marked as "Special". Leave empty for default.')
                        ->visible(function ($livewire) {
                            // Force the owner record to reload its attributes from the DB
                            $owner = $livewire->getOwnerRecord();
                            $owner->refresh(); 
                            
                            return (bool) $owner->is_special;
                        }),          
                    Forms\Components\Textarea::make('description')
                        ->nullable()
                        ->label('Status (Format: Passed / Full Slot / Cancel / Diskon - / 1 Left)'),
            
                    Forms\Components\Toggle::make('is_open')
                        ->label('Open?')
                        ->default(true),
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->prefix('IDR'),
                            
                        Forms\Components\TextInput::make('custom_dp_amount')
                            ->numeric()
                            ->label('Custom DP Amount')
                            ->prefix('IDR')
                            ->helperText('Only used if the Store is marked as "Special".')
                            ->visible(function ($livewire) {
                                // Force the owner record to reload its attributes from the DB
                                $owner = $livewire->getOwnerRecord();
                                $owner->refresh(); 
                                
                                return (bool) $owner->is_special;
                            }),
                        Forms\Components\Textarea::make('description')
                            ->nullable()
                            ->label('Status (Format: Passed / Full Slot / Cancel / Diskon - / 1 Left)'),
                
                        Forms\Components\Toggle::make('is_open')
                            ->label('Open?'),
                    ]),
                Tables\Actions\DetachAction::make(),
            ]);
    }
}
