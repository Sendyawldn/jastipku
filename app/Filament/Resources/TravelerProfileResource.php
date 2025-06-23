<?php
// filepath: c:\laragon\www\jastipku\app\Filament\Resources\TravelerProfileResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\TravelerProfileResource\Pages;
use App\Filament\Resources\TravelerProfileResource\RelationManagers;
use App\Models\TravelerProfile;
use App\Models\User; // Pastikan ini diimport
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight; // Tambahkan ini

class TravelerProfileResource extends Resource
{
    protected static ?string $model = TravelerProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification'; // Icon yang sesuai
    protected static ?string $navigationLabel = 'Verifikasi Traveler';
    protected static ?string $modelLabel = 'Profil Traveler';
    protected static ?string $pluralModelLabel = 'Profil Traveler';
    protected static ?string $navigationGroup = 'Manajemen User'; // Group di sidebar admin
    protected static ?int $navigationSort = 3; // Urutan di sidebar

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Traveler')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User (Traveler)')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(fn($record) => $record !== null),

                            Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->required()
                            ->numeric()
                            ->length(16)
                            ->disabled(fn($record) => $record !== null),// Tidak bisa diubah setelah dibuat

                        Forms\Components\FileUpload::make('id_card_path')
                            ->label('Foto KTP/Identitas')
                            ->image()
                            ->disk('public')
                            ->directory('id_cards')
                            ->nullable()
                            ->disabled(),

                        Forms\Components\Select::make('verification_status')
                            ->label('Status Verifikasi')
                            ->options([
                                'pending' => 'Pending (Menunggu Review)',
                                'verified' => 'Verified (Disetujui)',
                                'rejected' => 'Rejected (Ditolak)',
                            ])
                            ->required()
                            ->default('pending')
                            ->columnSpanFull()
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set, $record) {
                                // Jika status menjadi 'verified', set email_verified_at pada user terkait
                                if ($operation === 'edit' && $state === 'verified' && $record->user) {
                                    $record->user->forceFill([
                                        'email_verified_at' => now(), // Verifikasi email user juga
                                    ])->save();
                                }
                            }),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Detail Profil Tambahan')
                    ->schema([
                        Forms\Components\TextInput::make('rating')
                            ->label('Rating')
                            ->numeric()
                            ->readOnly(), // Rating dihitung otomatis

                        Forms\Components\Textarea::make('bio')
                            ->label('Bio')
                            ->nullable()
                            ->rows(3),

                        Forms\Components\Toggle::make('available_for_orders')
                            ->label('Tersedia untuk Menerima Pesanan')
                            ->default(true),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Informasi Rekening Bank')
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->label('Nama Bank')
                            ->nullable(),
                        Forms\Components\TextInput::make('bank_account_number')
                            ->label('Nomor Rekening')
                            ->nullable(),
                        Forms\Components\TextInput::make('bank_account_name')
                            ->label('Nama Pemilik Rekening')
                            ->nullable(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Traveler')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),

                    Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\BadgeColumn::make('verification_status')
                    ->label('Status Verifikasi')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'verified',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn($state) => $state ? number_format($state, 1) . ' ⭐' : '-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('available_for_orders')
                    ->label('Tersedia Order')
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('verification_status')
                    ->label('Status Verifikasi')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->using(function (TravelerProfile $record, array $data): TravelerProfile {
                        // Jika status berubah menjadi verified, set email_verified_at pada user
                        if ($record->verification_status !== 'verified' && $data['verification_status'] === 'verified') {
                            $record->user->forceFill([
                                'email_verified_at' => now(),
                            ])->save();
                        }
                        $record->update($data);
                        return $record;
                    }),
                Tables\Actions\DeleteAction::make(),

                // Aksi cepat untuk verifikasi
                Tables\Actions\Action::make('verify_profile')
                    ->label('Set Verified')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->action(function (TravelerProfile $record): void {
                        $record->update(['verification_status' => 'verified']);
                        // Juga verifikasi email user terkait
                        if ($record->user) {
                            $record->user->forceFill(['email_verified_at' => now()])->save();
                        }
                    })
                    ->requiresConfirmation()
                    ->visible(fn(TravelerProfile $record): bool => $record->verification_status === 'pending'),

                Tables\Actions\Action::make('reject_profile')
                    ->label('Set Rejected')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(fn(TravelerProfile $record) => $record->update(['verification_status' => 'rejected']))
                    ->requiresConfirmation()
                    ->visible(fn(TravelerProfile $record): bool => $record->verification_status === 'pending'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTravelerProfiles::route('/'),
            'create' => Pages\CreateTravelerProfile::route('/create'),
            'edit' => Pages\EditTravelerProfile::route('/{record}/edit'),
        ];
    }

    // Badge di navigasi admin untuk menunjukkan jumlah traveler pending
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('verification_status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }
}