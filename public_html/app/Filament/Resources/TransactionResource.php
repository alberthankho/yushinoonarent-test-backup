<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Database\Eloquent\Model;


class TransactionResource extends Resource
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
    
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make() // Main column
                    ->schema([
                        Section::make('Transaction & Product Details')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->maxLength(255)
                                        ->label('Tenant Name'),
                                    TextInput::make('trx_id')
                                        ->required()
                                        ->maxLength(255)
                                        ->label('Transaction ID')
                                        ->unique(Transaction::class, 'trx_id', ignoreRecord: true),
                                ]),
                                Grid::make(2)->schema([
                                    Select::make('product_id')
                                        ->required()
                                        ->relationship('product', 'name')
                                        ->searchable()
                                        ->preload(),
                                    Select::make('store_id')
                                        ->required()
                                        ->relationship(
                                            'store', // Name
                                            'name',  // Title Attribute
                                            fn (\Illuminate\Database\Eloquent\Builder $query) => $query->withTrashed() // Modify Query
                                        )
                                        ->searchable()
                                        ->preload(),
                                ]),
                                Grid::make(2)->schema([
                                    DatePicker::make('started_at')->required(),
                                    DatePicker::make('ended_at')->required(),
                                ]),
                                TextInput::make('event_rent_session') // New Field
                                    ->maxLength(255),
                            ]),

                        Section::make('Tenant Information') // NEW SECTION
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('phone_number')
                                        ->required()
                                        ->tel()
                                        ->maxLength(255),
                                    TextInput::make('email') // New Field
                                        ->email()
                                        ->maxLength(255),
                                ]),
                                TextInput::make('nik') // New Field
                                    ->label('NIK')
                                    ->maxLength(255),
                                Textarea::make('address')
                                    ->required()
                                    ->label('Current Address (Main)')
                                    ->columnSpanFull(),
                                Textarea::make('tenants_address_ktp') // New Field
                                    ->label('Address according to KTP')
                                    ->columnSpanFull(),
                                Textarea::make('tenants_address_domicile') // New Field
                                    ->label('Domicile Address')
                                    ->columnSpanFull(),
                                Grid::make(2)->schema([
                                    TextInput::make('twitter')->maxLength(255), // New Field
                                    TextInput::make('instagram')->maxLength(255), // New Field
                                ]),
                            ]),
                        
                        Section::make('Guarantor Information') // NEW SECTION
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('guarantor_name')->maxLength(255),
                                    TextInput::make('relationship_with_guarantor')->maxLength(255),
                                ]),
                                TextInput::make('guarantor_phone')->tel()->maxLength(255),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make() // Sidebar
                    ->schema([
                        Section::make('Payment & Delivery')
                            ->schema([
                                TextInput::make('total_amount')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR'),
                                    // Add new amount fields here
                                TextInput::make('dp_amount')
                                    ->label('Down Payment Amount')
                                    ->numeric()->prefix('IDR'),
                                TextInput::make('materai_amount')
                                    ->label('Materai Fee')
                                    ->numeric()->prefix('IDR'),
                                TextInput::make('unpaid_amount')
                                    ->label('Unpaid Amount')
                                    ->numeric()->prefix('IDR'),
                                TextInput::make('midtrans_fee')
                                    ->label('Midtrans Fee')
                                    ->numeric()->prefix('IDR')
                                    ->required(),
                                TextInput::make('referal_fee')
                                    ->label('Referal Fee Amount')
                                    ->numeric()->prefix('IDR'),
                                TextInput::make('expense_fee')
                                    ->label('Expense Fee Amount')
                                    ->numeric()->prefix('IDR'),
                                TextInput::make('duration')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Days'),
                                Select::make('is_paid')
                                    ->required()
                                    ->options([
                                        true => 'Paid',
                                        false => 'Not Paid',
                                    ])->boolean(),
                                Select::make('is_dp_paid')
                                    ->required()
                                    ->options([
                                        true => 'Paid',
                                        false => 'Not Paid',
                                    ])->boolean(),
                                Select::make('delivery_type')
                                    ->required()
                                    ->options([
                                        'pickup' => 'Pickup Store',
                                        'home_delivery' => 'Home Delivery',
                                    ]),
                                FileUpload::make('proof')
                                    ->required()
                                    ->image()
                                    ->openable()
                                    ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'])
                                    ->directory('transaction-proofs'),
                            ]),
                        
                        Section::make('Identification Documents') // NEW SECTION
                            ->schema([
                                Select::make('first_identification_type') // New Field
                                    ->options(['KTP' => 'KTP'])
                                    ->default('KTP')
                                    ->disabled(), // It's always KTP
                                Select::make('second_identification_type') // New Field
                                    ->options([
                                        'SIM' => 'SIM',
                                        'Paspor' => 'Paspor',
                                        'Kartu Pelajar/Mahasiswa/NPWP' => 'Kartu Pelajar/Mahasiswa/NPWP',
                                        'STNK/BPKB' => 'STNK/BPKB',
                                        'Others' => 'Others',
                                    ])
                                    ->live(), // Make it live to interact with the next field
                                TextInput::make('second_identification_value') // New Field
                                    ->label('Second ID Value / Details')
                                    ->visible(fn ($get) => $get('second_identification_type') !== null), // Only show if a type is selected
                            ]),

                        Section::make('Image Uploads') // NEW, CORRECTED SECTION
                        ->schema([
                            Forms\Components\Repeater::make('ticketScreenshots') // Use the relationship name
                                ->relationship() // This links the repeater to the relationship
                                ->label('Ticket Screenshot(s)')
                                ->schema([
                                    FileUpload::make('image_path')
                                        ->label('Screenshot Image')
                                        ->required()
                                        ->image()
                                        ->openable()
                                        ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'])
                                        ->directory('transaction-images/ticket-screenshots')
                                        // No ->multiple() here, as each repeater item is one image.
                                ])
                                ->maxItems(2) // Enforce your validation rule
                                ->addActionLabel('Add Screenshot') // Customize the "Add" button text
                                ->columns(1), // Each item in its own row

                            Forms\Components\Repeater::make('userIdentifications')
                                ->relationship()
                                ->label('User Identification(s)')
                                ->schema([
                                    FileUpload::make('image_path')
                                        ->label('Identification Image')
                                        ->required()
                                        ->image()
                                        ->openable()
                                        ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'])
                                        ->directory('transaction-images/user-identifications'),
                                ])
                                ->maxItems(5)
                                ->addActionLabel('Add Identification Image')
                                ->columns(1),

                            Forms\Components\Repeater::make('userSelfies')
                                ->relationship()
                                ->label('User Selfie(s) (Foto Selfie Penyewa)')
                                ->schema([
                                    FileUpload::make('image_path')
                                        ->label('Selfie Image')
                                        // ->required()
                                        ->image()
                                        ->openable()
                                        ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'])
                                        ->directory('transaction-images/user-selfies'),
                                ])
                                ->maxItems(5)
                                ->addActionLabel('Add Selfie')
                                ->columns(1),

                            Forms\Components\Repeater::make('productReturns')
                                ->relationship()
                                ->label('Product Return Image(s) (Bukti Pengembalian)')
                                ->schema([
                                    FileUpload::make('image_path')
                                        ->label('Return Image')
                                        ->image()
                                        ->openable()
                                        ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'])
                                        ->directory('transaction-images/product-returns'),
                                ])
                                ->maxItems(5)
                                ->addActionLabel('Add Return Image')
                                ->columns(1),
                            Forms\Components\Repeater::make('buktiPelunasans')
                                ->relationship()
                                ->label('Proof of Final Payment (Bukti Pelunasan)')
                                ->schema([
                                    FileUpload::make('image_path')
                                        ->label('Payment Proof Image')
                                        ->image()
                                        ->openable()
                                        ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'])
                                        ->directory('transaction-images/final-payment-proofs'),
                                ])
                                ->maxItems(5)
                                ->addActionLabel('Add Final Payment Proof')
                                ->columns(1),
                        
                        ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trx_id')
                    ->searchable()
                    ->label('Transaction ID'),
                TextColumn::make('name')
                    ->searchable()
                    ->label('Tenant Name'),
                TextColumn::make('store.name')
                    ->searchable()
                    ->sortable()
                    ->label('Concert Name'),
                TextColumn::make('product.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->money('IDR'),
                    // Add new columns for the amounts, hidden by default to keep table clean
                TextColumn::make('dp_amount')->money('IDR')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('unpaid_amount')->money('IDR')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('midtrans_fee')->money('IDR')->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->label('Paid'),
                IconColumn::make('is_dp_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->label('DP Paid'),
                TextColumn::make('email') // New Column
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default
                TextColumn::make('phone_number') // New Column
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('started_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('ended_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])

            ->headerActions([
                Action::make('export')
                    ->label('Export Spreadsheet')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function ($livewire) {
                        
                        $fileName = 'transactions-' . date('Y-m-d-His') . '.csv'; 
            
                        return response()->streamDownload(function () use ($livewire) {
                            $file = fopen('php://output', 'w');
            
                            // 1. Define all the headers for your CSV file
                            fputcsv($file, [
                                'ID',
                                'Transaction ID',
                                'Tenant Name',
                                'Email',
                                'Phone Number',
                                'Product',
                                'Event / Store',
                                'Duration (Days)',
                                'Started At',
                                'Ended At',
                                'NIK',
                                'KTP Address',
                                'Domicile Address',
                                'Instagram',
                                'Twitter / X',
                                'Guarantor Name',
                                'Relationship',
                                'Guarantor Phone',
                                'Total Amount',
                                'DP Amount',
                                'Materai Fee',
                                'Unpaid Amount',
                                'Midtrans Fee',
                                'Referal Fee',
                                'Expense Fee',
                                'DP Paid Status',
                                'Final Payment Status',
                                'Booking Date',
                            ]);
            
                            // 2. Loop through your data and add the corresponding values
                            $livewire->getFilteredTableQuery()->chunk(200, function ($transactions) use ($file) {
                                foreach ($transactions as $transaction) {
                                    fputcsv($file, [
                                        $transaction->id,
                                        $transaction->trx_id,
                                        $transaction->name,
                                        $transaction->email,
                                        $transaction->phone_number,
                                        $transaction->product->name ?? 'N/A',
                                        $transaction->store->name ?? 'N/A',
                                        $transaction->duration,
                                        $transaction->started_at->format('Y-m-d'),
                                        $transaction->ended_at->format('Y-m-d'),
                                        $transaction->nik,
                                        $transaction->tenants_address_ktp,
                                        $transaction->tenants_address_domicile,
                                        $transaction->instagram,
                                        $transaction->twitter,
                                        $transaction->guarantor_name,
                                        $transaction->relationship_with_guarantor,
                                        $transaction->guarantor_phone,
                                        $transaction->total_amount,
                                        $transaction->dp_amount,
                                        $transaction->materai_amount,
                                        $transaction->unpaid_amount,
                                        $transaction->midtrans_fee,
                                        $transaction->referal_fee,
                                        $transaction->expense_fee,
                                        $transaction->is_dp_paid ? 'Paid' : 'Not Paid',
                                        $transaction->is_paid ? 'Paid' : 'Not Paid',
                                        $transaction->created_at->format('Y-m-d H:i:s'),
                                    ]);
                                }
                            });
            
                            fclose($file);
                        }, $fileName);
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('downloadPdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->action(function (Transaction $record) {
                        $record->loadMissing(['product', 'store']);
                        $pdf = Pdf::loadView('pdf.transaction', ['transaction' => $record]);
                        $filename = 'transaction_' . $record->trx_id . '_' . now()->format('YmdHis') . '.pdf';
                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            $filename
                        );
                    }),
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
            // If you want to view/manage the uploaded images as a relation manager on the Edit Page:
            // RelationManagers\TicketScreenshotsRelationManager::class,
            // RelationManagers\UserIdentificationsRelationManager::class,
            // RelationManagers\UserSelfiesRelationManager::class,
            // RelationManagers\ProductReturnsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}