<?php
// app/Filament/Resources/WithdrawalResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawalResource\Pages;
use App\Models\Withdrawal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;

class WithdrawalResource extends Resource
{
    protected static ?string $model = Withdrawal::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Penarikan Dana';
    protected static ?string $modelLabel = 'Penarikan Dana';
    protected static ?string $pluralModelLabel = 'Penarikan Dana';
    protected static ?string $navigationGroup = 'Manajemen Keuangan';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pemohon')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Traveler')
                            ->disabled(), // Tidak bisa diubah oleh admin
                        TextInput::make('amount')
                            ->label('Jumlah Penarikan')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(), // Tidak bisa diubah oleh admin
                    ])->columns(2),

                Section::make('Informasi Bank Tujuan')
                    ->description('Rekening bank milik traveler saat mengajukan penarikan.')
                    ->schema([
                        TextInput::make('bank_name')->label('Nama Bank')->disabled(),
                        TextInput::make('bank_account_number')->label('Nomor Rekening')->disabled(),
                        TextInput::make('bank_account_name')->label('Nama Pemilik Rekening')->disabled(),
                    ])->columns(3),

                Section::make('Proses Admin')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'Pending' => 'Pending',
                                'Processing' => 'Processing',
                                'Completed' => 'Completed',
                                'Rejected' => 'Rejected',
                            ])
                            ->required()
                            ->live() // Agar field lain bisa bereaksi terhadap perubahan status
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // Otomatis isi tanggal diproses jika status diubah ke Completed atau Rejected
                                if ($state === 'Completed' || $state === 'Rejected') {
                                    $set('processed_at', now());
                                }
                            }),
                        TextInput::make('transaction_id')->label('ID Transaksi / Bukti Transfer'),
                        Textarea::make('admin_notes')->label('Catatan Admin (Alasan ditolak, dll)')->columnSpanFull(),
                        DateTimePicker::make('processed_at')->label('Tanggal Diproses')->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Traveler')->searchable()->sortable(),
                TextColumn::make('amount')->label('Jumlah')->money('IDR')->sortable(),
                TextColumn::make('bank_name')->label('Bank')->searchable(),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'Pending',
                        'primary' => 'Processing',
                        'success' => 'Completed',
                        'danger' => 'Rejected',
                    ]),
                TextColumn::make('created_at')->label('Tanggal Diajukan')->dateTime('d M Y H:i')->sortable(),
                TextColumn::make('processed_at')->label('Tanggal Diproses')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Processing' => 'Processing',
                        'Completed' => 'Completed',
                        'Rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Proses'),
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListWithdrawals::route('/'),
            'edit' => Pages\EditWithdrawal::route('/{record}/edit'),
        ];
    }

    // Menonaktifkan tombol "Create" karena request dibuat oleh traveler, bukan admin
    public static function canCreate(): bool
    {
        return false;
    }

    // Menampilkan badge notifikasi di sidebar jika ada request pending
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'Pending')->count();
        return $count > 0 ? $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }
}
