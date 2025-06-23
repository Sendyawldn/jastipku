<?php
// filepath: c:\laragon\www\jastipku\app\Filament\Resources\UserResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\FontWeight;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Kelola Users';

    protected static ?string $navigationGroup = 'Manajemen User';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi User')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('role')
                            ->label('Role')
                            ->options([
                                'admin' => 'Admin',
                                'penitip' => 'Customer (Penitip)',
                                'traveler' => 'Traveler',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                            ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn($state) => filled($state)),
                    ]),

                Forms\Components\Section::make('Informasi Tambahan')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('No. Telepon')
                            ->tel(),

                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3),

                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At')
                            ->native(false),
                    ]),

                Forms\Components\Section::make('Rating & Stats (Khusus Traveler)')
                    ->schema([
                        Forms\Components\TextInput::make('rating')
                            ->label('Rating')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(5),

                        Forms\Components\TextInput::make('total_reviews')
                            ->label('Total Reviews')
                            ->numeric()
                            ->minValue(0),

                        Forms\Components\TextInput::make('completed_orders_count')
                            ->label('Pesanan Selesai')
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->visible(fn($get) => $get('role') === 'traveler'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->weight(FontWeight::SemiBold),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('role')
                    ->label('Role')
                    ->colors([
                        'danger' => 'admin',
                        'primary' => 'penitip',
                        'success' => 'traveler',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'admin' => 'Admin',
                        'penitip' => 'Customer',
                        'traveler' => 'Traveler',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state ? number_format($state, 1) . ' ⭐' : '-')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('completed_orders_count')
                    ->label('Orders Completed')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Bergabung')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'penitip' => 'Customer',
                        'traveler' => 'Traveler',
                    ]),

                Tables\Filters\Filter::make('verified')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('email_verified_at'))
                    ->label('Email Verified'),

                Tables\Filters\Filter::make('unverified')
                    ->query(fn(Builder $query): Builder => $query->whereNull('email_verified_at'))
                    ->label('Email Unverified'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('verify_email')
                    ->label('Verify Email')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->action(fn(User $record) => $record->update(['email_verified_at' => now()]))
                    ->requiresConfirmation()
                    ->visible(fn(User $record): bool => is_null($record->email_verified_at)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
