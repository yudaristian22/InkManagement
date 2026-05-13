<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InkResource\Pages;
use App\Filament\Resources\InkResource\RelationManagers;
use App\Models\Ink;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InkResource extends Resource
{
    protected static ?string $model = Ink::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                ->label('Kode Tinta')
                ->required()
                ->unique(ignoreRecord:true),
                TextInput::make('color')
                ->label('Warna')
                ->required(),
                Toggle::make('is_original')
                ->label('Tinta Original')
                ->default(true)
                ->helperText('Matikan toggle ini jika ini adalah tinta refill (botol besar) agar stok tidak dikurangi otomatis.'),
                TextInput::make('stock')
                ->label('Stock Saat Ini')
                ->numeric()
                ->default(0)
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                ->label('Kode Tinta')
                ->sortable()
                ->searchable(),
                TextColumn::make('color')
                ->label('Warna')
                ->sortable()
                ->searchable(),
                IconColumn::make('is_original')
                ->label('Tinta Original')
                ->boolean(),
                TextColumn::make('stock')
                ->label('Stock Saat Ini')
                ->sortable()
                ->searchable(),
            ])
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
            'index' => Pages\ListInks::route('/'),
            'create' => Pages\CreateInk::route('/create'),
            'edit' => Pages\EditInk::route('/{record}/edit'),
        ];
    }
}
