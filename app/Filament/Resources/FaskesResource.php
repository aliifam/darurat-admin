<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaskesResource\Pages;
use App\Models\Faskes;
use ArberMustafa\FilamentLocationPickrField\Forms\Components\LocationPickr;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaskesResource extends Resource
{
    protected static ?string $model = Faskes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->label(__('Nama Faskes'))
                    ->placeholder(__('Nama Faskes')),
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
                    ->type('email')
                    ->label(__('Email'))
                    ->placeholder(__('Email')),
                TextInput::make('website')
                    ->label(__('Website'))
                    ->placeholder(__('Website')),
                Select::make('jenis')
                    ->required()
                    ->searchable()
                    ->options([
                        'rumah_sakit' => __('Rumah Sakit'),
                        'klinik' => __('Klinik'),
                        'puskesmas' => __('Puskesmas'),
                    ])
                    ->label(__('Jenis Faskes')),
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
                Toggle::make('bpjs')
                    ->label(__('Menerima BPJS'))
                    ->inline(false)
                    ->required(),
                Toggle::make('available')
                    ->label(__('Layanan Tersedia'))
                    ->inline(false)
                    ->required(),
                TextInput::make('username')
                    ->required()
                    ->unique()
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
                TextColumn::make('jenis')
                    ->searchable()
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
            'index' => Pages\ListFaskes::route('/'),
            'create' => Pages\CreateFaskes::route('/create'),
            'edit' => Pages\EditFaskes::route('/{record}/edit'),
        ];
    }
}
