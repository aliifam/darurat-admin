<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolisiResource\Pages;
use App\Filament\Resources\PolisiResource\RelationManagers;
use App\Models\Polisi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PolisiResource extends Resource
{
    protected static ?string $model = Polisi::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Data Polisi';
    protected static ?string $pluralModelLabel = 'Data Kantor Polisi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListPolisis::route('/'),
            'create' => Pages\CreatePolisi::route('/create'),
            'edit' => Pages\EditPolisi::route('/{record}/edit'),
        ];
    }
}
