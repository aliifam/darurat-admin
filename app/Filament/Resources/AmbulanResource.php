<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AmbulanResource\Pages;
use App\Filament\Resources\AmbulanResource\RelationManagers;
use App\Models\Ambulan;
use ArberMustafa\FilamentLocationPickrField\Forms\Components\LocationPickr;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AmbulanResource extends Resource
{
    protected static ?string $model = Ambulan::class;

    protected static ?string $navigationIcon = 'heroicon-o-speaker-wave';

    protected static ?string $navigationLabel = 'Data Ambulan';
    protected static ?string $pluralModelLabel = 'Data Ambulan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->label(__('Nama Ambulan'))
                    ->placeholder(__('Nama Ambulan')),
                TextInput::make('telepon')
                    ->required()
                    ->label(__('Telepon'))
                    ->placeholder(__('Telepon')),
                TextInput::make('wa')
                    ->required()
                    ->label(__('Whatsapp'))
                    ->placeholder(__('Whatsapp')),
                LocationPickr::make('location')
                    ->mapControls([
                        'mapTypeControl'    => true,
                        'scaleControl'      => true,
                        'streetViewControl' => true,
                        'rotateControl'     => true,
                        'fullscreenControl' => true,
                        'zoomControl'       => true,
                    ])
                    ->defaultZoom(15)
                    ->draggable()
                    ->clickable()
                    ->height('40vh')
                    ->defaultLocation([-6.175392, 106.827153])
                    ->myLocationButtonLabel('Lokasi Sekarang')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $set('latitude', $state['lat']);
                        $set('longitude', $state['lng']);
                    }),
                TextInput::make('latitude')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $set('location', [
                            'lat' => floatVal($state),
                            'lng' => floatVal($get('longitude')),
                        ]);
                    })
                    ->lazy(),
                TextInput::make('longitude')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $set('location', [
                            'lat' => floatval($get('latitude')),
                            'lng' => floatVal($state),
                        ]);
                    })
                    ->lazy(),
                Toggle::make('free')
                    ->label(__('Layanan Gratis'))
                    ->inline(false)
                    ->required(),
                Toggle::make('available')
                    ->label(__('Layanan Tersedia'))
                    ->inline(false)
                    ->required(),
                TextInput::make('username')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label(__('Username'))
                    ->placeholder(__('Username')),
                TextInput::make('password')
                    ->required()
                    ->label(__('Password'))
                    ->placeholder(__('Password')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('free')
                    ->label(__('Layanan Gratis'))
                    ->inline(false)
                    ->sortable(),
                TextColumn::make('wa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('latitude')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('longitude')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAmbulans::route('/'),
            'create' => Pages\CreateAmbulan::route('/create'),
            'edit' => Pages\EditAmbulan::route('/{record}/edit'),
        ];
    }
}
