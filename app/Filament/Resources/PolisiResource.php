<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolisiResource\Pages;
use App\Filament\Resources\PolisiResource\RelationManagers;
use App\Models\Polisi;
use ArberMustafa\FilamentLocationPickrField\Forms\Components\LocationPickr;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
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
                TextInput::make('nama')
                    ->required()
                    ->label(__('Nama Kantor Polisi'))
                    ->placeholder(__('Nama Kantor Polisi')),
                Textarea::make('alamat')
                    ->required()
                    ->label(__('Alamat'))
                    ->placeholder(__('Alamat')),
                TextInput::make('telepon')
                    ->required()
                    ->label(__('Telepon'))
                    ->placeholder(__('Telepon')),
                TextInput::make('wa')
                    ->required()
                    ->label(__('Whatsapp'))
                    ->placeholder(__('Whatsapp')),
                TextInput::make('email')
                    ->required()
                    ->label(__('Email'))
                    ->placeholder(__('Email')),
                LocationPickr::make('location')
                    ->label(__('Lokasi Kantor Polisi'))
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
                TextInput::make('website')
                    ->label(__('Website'))
                    ->placeholder(__('Website')),
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
                TextColumn::make('alamat')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('available')
                    ->label(__('Layanan Tersedia'))
                    ->formatStateUsing(function (bool $state) {
                        return $state ? 'Ya' : 'Tidak';
                    })
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                TextColumn::make('telepon')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
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
