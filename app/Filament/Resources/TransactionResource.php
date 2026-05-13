<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Ink;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                ->label('Tanggal Transaksi')
                ->default(now())
                ->required(),
                Select::make('department_id')
                ->label('Departemen Tujuan')
                ->relationship('department','name')
                ->required(),

                // Kolom ini disembunyikan tapi otomatis menyimpan ID dari akun IT yang sedang login
                Hidden::make('user_id')
                ->default(fn () => auth()->id()),

                // Ini fitur repeater untuk multi-warna
                Repeater::make('transactionDetails')
                ->relationship() // Mengambil relasi hasMany dari Model Transaction
                ->schema([
                    Select::make('ink_id')
                    ->label('Pilih Tinta')
                    ->options(Ink::all()->mapWithKeys(function ($ink) {
                        $type = $ink->is_original ? 'Original' : 'Refill';
                        return [$ink->id => "{$ink->code} - {$ink->color} {$type} (Stok: {$ink->stock})"];
                    }))
                    ->searchable() // Menampilkan kode tinta di dropdown
                    ->required()
                    ->columnSpan(2),
                    TextInput::make('quantity')
                        ->label('Jumlah Dipakai')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->required()
                        ->columnSpan(1),
                ])
                ->columns(3) // Membagi form repeater menjadi 3 kolom agar sejajar
                ->columnSpanFull() // Mengambil lebar form penuh
                ->addActionLabel('Tambah Warna Tinta Lain'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                ->label('Tanggal Transaksi')
                ->sortable()
                ->date('d M Y'),
                TextColumn::make('department.name')
                ->label('Departemen')
                ->searchable(),
                TextColumn::make('user.name')
                ->label('Dibuat Oleh')
                ->sortable()
                ->searchable(),
                TextColumn::make('transactionDetails_count')
                ->counts('transactionDetails')
                ->label('Jumlah Warna Tinta')
                ->badge(),
            ])
            ->defaultSort('date','desc')
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
