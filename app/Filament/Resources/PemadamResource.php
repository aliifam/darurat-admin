<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemadamResource\Pages;
use App\Filament\Resources\PemadamResource\RelationManagers;
use App\Models\Pemadam;
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
                TextInput::make('nama')
                    ->required()
                    ->label(__('Nama Pemadam'))
                    ->placeholder(__('Nama Pemadam')),
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
            'index' => Pages\ListPemadams::route('/'),
            'create' => Pages\CreatePemadam::route('/create'),
            'edit' => Pages\EditPemadam::route('/{record}/edit'),
        ];
    }
}
