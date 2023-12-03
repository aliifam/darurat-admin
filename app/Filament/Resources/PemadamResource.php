<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemadamResource\Pages;
use App\Filament\Resources\PemadamResource\RelationManagers;
use App\Models\Pemadam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PemadamResource extends Resource
{
    protected static ?string $model = Pemadam::class;

    protected static ?string $navigationIcon = 'heroicon-o-fire';

    protected static ?string $navigationLabel = 'Data Pemadam';
    protected static ?string $pluralModelLabel = 'Data Pemadam Kebakaran';

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
            'index' => Pages\ListPemadams::route('/'),
            'create' => Pages\CreatePemadam::route('/create'),
            'edit' => Pages\EditPemadam::route('/{record}/edit'),
        ];
    }
}
