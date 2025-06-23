<?php
// filepath: c:\laragon\www\jastipku\app\Filament\Resources\OrderResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Kelola Pesanan';

    protected static ?string $modelLabel = 'Pesanan';

    protected static ?string $pluralModelLabel = 'Pesanan';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Manajemen Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pesanan')
                    ->description('Detail pesanan dari customer')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('nama_barang')
                                    ->label('Nama Barang')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                Forms\Components\Select::make('kategori')
                                    ->label('Kategori')
                                    ->options([
                                        'fashion' => 'Fashion & Pakaian',
                                        'skincare' => 'Skincare & Beauty',
                                        'elektronik' => 'Elektronik',
                                        'makanan' => 'Makanan & Minuman',
                                        'buku' => 'Buku & Media',
                                        'beauty' => 'Beauty & Personal Care',
                                        'accessories' => 'Aksesoris',
                                        'toys' => 'Mainan & Hobi',
                                        'sports' => 'Olahraga & Outdoor',
                                        'home' => 'Rumah & Dekorasi',
                                        'lainnya' => 'Lainnya',
                                    ])
                                    ->required()
                                    ->columnSpan(1),
                            ]),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi Barang')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('budget')
                                    ->label('Budget (Rp)')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->step(1000)
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('ongkos_jasa_otomatis')
                                    ->label('Ongkos Jasa Otomatis (Rp)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->step(1000)
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('ongkos_jasa')
                                    ->label('Ongkos Jasa Final (Rp)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->step(1000)
                                    ->columnSpan(1),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('destination')
                                    ->label('Tujuan')
                                    ->options([
                                        // Jawa
                                        'jakarta' => 'Jakarta',
                                        'bandung' => 'Bandung',
                                        'surabaya' => 'Surabaya',
                                        'yogyakarta' => 'Yogyakarta',
                                        'semarang' => 'Semarang',
                                        'malang' => 'Malang',
                                        'solo' => 'Solo',
                                        'bogor' => 'Bogor',
                                        'depok' => 'Depok',
                                        'bekasi' => 'Bekasi',
                                        'tangerang' => 'Tangerang',

                                        // Sumatera
                                        'medan' => 'Medan',
                                        'palembang' => 'Palembang',
                                        'pekanbaru' => 'Pekanbaru',
                                        'padang' => 'Padang',
                                        'bandar_lampung' => 'Bandar Lampung',
                                        'batam' => 'Batam',

                                        // Kalimantan
                                        'banjarmasin' => 'Banjarmasin',
                                        'balikpapan' => 'Balikpapan',
                                        'samarinda' => 'Samarinda',
                                        'pontianak' => 'Pontianak',

                                        // Sulawesi
                                        'makassar' => 'Makassar',
                                        'manado' => 'Manado',
                                        'palu' => 'Palu',
                                        'kendari' => 'Kendari',

                                        // Bali & Nusa Tenggara
                                        'denpasar' => 'Denpasar',
                                        'mataram' => 'Mataram',
                                        'kupang' => 'Kupang',
                                        'labuan_bajo' => 'Labuan Bajo',

                                        // Papua & Maluku
                                        'jayapura' => 'Jayapura',
                                        'ambon' => 'Ambon',
                                        'sorong' => 'Sorong',
                                        'merauke' => 'Merauke',
                                    ])
                                    ->required()
                                    ->searchable()
                                    ->columnSpan(1),

                                Forms\Components\DateTimePicker::make('deadline')
                                    ->label('Deadline')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('d/m/Y H:i')
                                    ->columnSpan(1),
                            ]),

                        Forms\Components\TextInput::make('link_produk')
                            ->label('Link Produk')
                            ->url()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Informasi Customer & Pengiriman')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Textarea::make('alamat_pengiriman')
                            ->label('Alamat Pengiriman')
                            ->required()
                            ->rows(2),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('no_telepon')
                                    ->label('No. Telepon')
                                    ->required()
                                    ->tel(),

                                Forms\Components\Select::make('metode_pembayaran')
                                    ->label('Metode Pembayaran')
                                    ->options([
                                        'bank_transfer' => 'Bank Transfer',
                                        'ewallet' => 'E-Wallet',
                                        'virtual_account' => 'Virtual Account',
                                        'qris' => 'QRIS',
                                        'cash_on_delivery' => 'Cash on Delivery',
                                    ])
                                    ->required(),
                            ]),
                    ]),

                Forms\Components\Section::make('Status & Traveler')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status Pesanan')
                                    ->options([
                                        'pending' => 'Pending',
                                        'accepted' => 'Diterima',
                                        'in_progress' => 'Sedang Diproses',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ])
                                    ->required()
                                    ->live(),

                                Forms\Components\Select::make('traveler_id')
                                    ->label('Traveler')
                                    ->relationship('traveler', 'name', fn(Builder $query) => $query->where('role', 'traveler'))
                                    ->searchable()
                                    ->preload()
                                    ->nullable(),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('payment_status')
                                    ->label('Status Pembayaran')
                                    ->options([
                                        'pending' => 'Pending',
                                        'paid' => 'Sudah Dibayar',
                                        'completed' => 'Selesai',
                                        'refunded' => 'Dikembalikan',
                                    ])
                                    ->default('pending'),

                                Forms\Components\TextInput::make('total_pembayaran')
                                    ->label('Total Pembayaran (Rp)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->step(1000),
                            ]),
                    ]),

                Forms\Components\Section::make('Catatan & File')
                    ->schema([
                        Forms\Components\Textarea::make('catatan_khusus')
                            ->label('Catatan Khusus')
                            ->rows(3),

                        Forms\Components\Textarea::make('catatan_penyelesaian')
                            ->label('Catatan Penyelesaian')
                            ->rows(3),

                        Forms\Components\Textarea::make('cancel_reason')
                            ->label('Alasan Pembatalan')
                            ->rows(2)
                            ->visible(fn($get) => $get('status') === 'cancelled'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->weight(FontWeight::SemiBold)
                    ->wrap()
                    ->limit(30),

                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('traveler.name')
                    ->label('Traveler')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Belum ada'),

                Tables\Columns\TextColumn::make('budget')
                    ->label('Budget')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state ?? 0, 0, ',', '.'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('ongkos_jasa_otomatis')
                    ->label('Ongkos Auto')
                    ->formatStateUsing(fn($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : '-')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('ongkos_jasa')
                    ->label('Ongkos Final')
                    ->formatStateUsing(fn($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : '-')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('destination')
                    ->label('Tujuan')
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => ucwords(str_replace('_', ' ', $state))),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'pending',
                        'warning' => 'accepted',
                        'primary' => 'in_progress',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'accepted' => 'Diterima',
                        'in_progress' => 'Diproses',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    }),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Payment')
                    ->colors([
                        'secondary' => 'pending',
                        'success' => ['paid', 'completed'],
                        'danger' => 'refunded',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'paid' => 'Dibayar',
                        'completed' => 'Selesai',
                        'refunded' => 'Refund',
                        default => $state,
                    })
                    ->toggleable(),

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';
                        try {
                            return \Carbon\Carbon::parse($state)->format('d M Y, H:i');
                        } catch (\Exception $e) {
                            return $state; // fallback to original value
                        }
                    })
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';
                        try {
                            return \Carbon\Carbon::parse($state)->format('d M Y, H:i');
                        } catch (\Exception $e) {
                            return $state;
                        }
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Selesai')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';
                        try {
                            return \Carbon\Carbon::parse($state)->format('d M Y, H:i');
                        } catch (\Exception $e) {
                            return $state;
                        }
                    })
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Diterima',
                        'in_progress' => 'Sedang Diproses',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),

                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Sudah Dibayar',
                        'completed' => 'Selesai',
                        'refunded' => 'Dikembalikan',
                    ]),

                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'fashion' => 'Fashion & Pakaian',
                        'skincare' => 'Skincare & Beauty',
                        'elektronik' => 'Elektronik',
                        'makanan' => 'Makanan & Minuman',
                        'buku' => 'Buku & Media',
                        'beauty' => 'Beauty & Personal Care',
                        'accessories' => 'Aksesoris',
                        'toys' => 'Mainan & Hobi',
                        'sports' => 'Olahraga & Outdoor',
                        'home' => 'Rumah & Dekorasi',
                        'lainnya' => 'Lainnya',
                    ]),

                Tables\Filters\Filter::make('budget_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('budget_from')
                                    ->label('Budget Minimal')
                                    ->numeric()
                                    ->prefix('Rp'),
                                Forms\Components\TextInput::make('budget_to')
                                    ->label('Budget Maksimal')
                                    ->numeric()
                                    ->prefix('Rp'),
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['budget_from'],
                                fn(Builder $query, $budget): Builder => $query->where('budget', '>=', $budget),
                            )
                            ->when(
                                $data['budget_to'],
                                fn(Builder $query, $budget): Builder => $query->where('budget', '<=', $budget),
                            );
                    }),

                Tables\Filters\Filter::make('deadline_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('deadline_from')
                                    ->label('Deadline Dari'),
                                Forms\Components\DatePicker::make('deadline_to')
                                    ->label('Deadline Sampai'),
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['deadline_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('deadline', '>=', $date),
                            )
                            ->when(
                                $data['deadline_to'],
                                fn(Builder $query, $date): Builder => $query->whereDate('deadline', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),
                Tables\Actions\EditAction::make()
                    ->label('Edit'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),

                Tables\Actions\Action::make('assign_traveler')
                    ->label('Assign')
                    ->icon('heroicon-o-user-plus')
                    ->color('success')
                    ->form([
                        Forms\Components\Select::make('traveler_id')
                            ->label('Pilih Traveler')
                            ->options(User::where('role', 'traveler')->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (Order $record, array $data): void {
                        $record->update([
                            'traveler_id' => $data['traveler_id'],
                            'status' => 'accepted',
                            'accepted_at' => now(),
                        ]);
                    })
                    ->requiresConfirmation()
                    ->visible(fn(Order $record): bool => $record->status === 'pending'),

                Tables\Actions\Action::make('complete_order')
                    ->label('Selesaikan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('total_belanja')
                            ->label('Total Belanja (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\TextInput::make('ongkos_jasa_final')
                            ->label('Ongkos Jasa Final (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\Textarea::make('catatan_penyelesaian')
                            ->label('Catatan Penyelesaian')
                            ->rows(3),
                    ])
                    ->action(function (Order $record, array $data): void {
                        $totalPembayaran = $data['total_belanja'] + $data['ongkos_jasa_final'];

                        $record->update([
                            'status' => 'completed',
                            'total_belanja' => $data['total_belanja'],
                            'ongkos_jasa' => $data['ongkos_jasa_final'],
                            'total_pembayaran' => $totalPembayaran,
                            'completed_at' => now(),
                            'payment_status' => 'completed',
                            'catatan_penyelesaian' => $data['catatan_penyelesaian'],
                        ]);

                        // Update traveler rating if exists
                        if ($record->traveler && method_exists($record->traveler, 'updateRating')) {
                            $record->traveler->updateRating();
                        }
                    })
                    ->requiresConfirmation()
                    ->visible(fn(Order $record): bool => $record->status === 'in_progress'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('bulk_status_update')
                        ->label('Update Status')
                        ->icon('heroicon-o-pencil-square')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('Status Baru')
                                ->options([
                                    'pending' => 'Pending',
                                    'accepted' => 'Diterima',
                                    'in_progress' => 'Sedang Diproses',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ])
                                ->required(),
                        ])
                        ->action(function ($records, array $data): void {
                            foreach ($records as $record) {
                                $record->update(['status' => $data['status']]);
                            }
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Pesanan')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('nama_barang')
                                    ->label('Nama Barang')
                                    ->weight(FontWeight::SemiBold),
                                Infolists\Components\TextEntry::make('kategori')
                                    ->label('Kategori')
                                    ->badge(),
                            ]),

                        Infolists\Components\TextEntry::make('deskripsi')
                            ->label('Deskripsi')
                            ->columnSpanFull(),

                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('budget')
                                    ->label('Budget')
                                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state ?? 0, 0, ',', '.')),
                                Infolists\Components\TextEntry::make('ongkos_jasa_otomatis')
                                    ->label('Ongkos Jasa Auto')
                                    ->formatStateUsing(fn($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : '-'),
                                Infolists\Components\TextEntry::make('ongkos_jasa')
                                    ->label('Ongkos Jasa Final')
                                    ->formatStateUsing(fn($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : '-'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Customer & Traveler')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('customer.name')
                                    ->label('Customer'),
                                Infolists\Components\TextEntry::make('traveler.name')
                                    ->label('Traveler')
                                    ->placeholder('Belum ada'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Status & Timeline')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Status')
                                    ->badge(),
                                Infolists\Components\TextEntry::make('payment_status')
                                    ->label('Status Pembayaran')
                                    ->badge(),
                                Infolists\Components\TextEntry::make('deadline')
                                    ->label('Deadline')
                                    ->formatStateUsing(function ($state) {
                                        if (!$state) return '-';
                                        try {
                                            return \Carbon\Carbon::parse($state)->format('d M Y, H:i');
                                        } catch (\Exception $e) {
                                            return $state;
                                        }
                                    }),
                            ]),

                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Dibuat')
                                    ->formatStateUsing(function ($state) {
                                        if (!$state) return '-';
                                        try {
                                            return \Carbon\Carbon::parse($state)->format('d M Y, H:i');
                                        } catch (\Exception $e) {
                                            return $state;
                                        }
                                    }),
                                Infolists\Components\TextEntry::make('accepted_at')
                                    ->label('Diterima')
                                    ->formatStateUsing(function ($state) {
                                        if (!$state) return 'Belum diterima';
                                        try {
                                            return \Carbon\Carbon::parse($state)->format('d M Y, H:i');
                                        } catch (\Exception $e) {
                                            return $state;
                                        }
                                    }),
                                Infolists\Components\TextEntry::make('completed_at')
                                    ->label('Selesai')
                                    ->formatStateUsing(function ($state) {
                                        if (!$state) return 'Belum selesai';
                                        try {
                                            return \Carbon\Carbon::parse($state)->format('d M Y, H:i');
                                        } catch (\Exception $e) {
                                            return $state;
                                        }
                                    }),
                            ]),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }
}
