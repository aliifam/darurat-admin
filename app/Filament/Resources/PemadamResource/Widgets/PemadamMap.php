<?php

namespace App\Filament\Resources\PemadamResource\Widgets;

use App\Models\Pemadam;
use Cheesegrits\FilamentGoogleMaps\Widgets\MapWidget;
use Filament\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class PemadamMap extends MapWidget
{
    protected static ?string $heading = 'Peta Pemadam Kebakaran';

    protected int | string | array $columnSpan = '2';
    protected static ?string $markerAction = 'markerAction';

    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = null;

    protected static ?bool $clustering = true;

    protected static ?bool $fitToBounds = true;

    protected static ?int $zoom = 12;

    protected function getData(): array
    {
        /**
         * You can use whatever query you want here, as long as it produces a set of records with your
         * lat and lng fields in them.
         */
        $locations = \App\Models\Pemadam::all();

        $data = [];

        foreach ($locations as $location) {
            /**
             * Each element in the returned data must be an array
             * containing a 'location' array of 'lat' and 'lng',
             * and a 'label' string (optional but recommended by Google
             * for accessibility.
             *
             * You should also include an 'id' attribute for internal use by this plugin
             */
            $data[] = [
                'location'  => [
                    'lat' => $location->latitude ? round(floatval($location->latitude), static::$precision) : 0,
                    'lng' => $location->longitude ? round(floatval($location->longitude), static::$precision) : 0,
                ],

                'label'     => $location->nama,

                'id' => $location->getKey(),

                /**
                 * Optionally you can provide custom icons for the map markers,
                 * either as scalable SVG's, or PNG, which doesn't support scaling.
                 * If you don't provide icons, the map will use the standard Google marker pin.
                 */
                'icon' => [
                    'url' => url('images/pemadam.png'),
                    'type' => 'svg',
                    'scale' => [35, 35],
                ],
            ];
        }

        return $data;
    }

    public function getConfig(): array
    {
        $config = parent::getConfig();

        // Disable points of interest
        $config['mapConfig']['styles'] = [
            [
                'featureType' => 'poi',
                'elementType' => 'labels',
                'stylers'     => [
                    ['visibility' => 'off'],
                ],
            ],
        ];

        return $config;
    }

    public function markerAction(): Action
    {
        return Action::make('markerAction')
            ->label('Detail Pemadam Kebakaran')
            ->infolist([
                Section::make([
                    TextEntry::make('nama'),
                    TextEntry::make('alamat')
                        ->label('Alamat')
                        ->copyable()
                        ->copyMessage('Copied!')
                        ->copyMessageDuration(1500),
                    TextEntry::make('wa')
                        ->label('Whatsapp')
                        ->formatStateUsing(function (string $state) {
                            // make link to whatsapp from wa number
                            $state = '<a href="https://wa.me/' . $state . '" target="_blank">' . $state . '</a>';
                            return $state;
                        })
                        ->html(),
                    TextEntry::make('telepon')
                        ->label('Telepon')
                        ->copyable()
                        ->copyMessage('Copied!')
                        ->copyMessageDuration(1500),
                    TextEntry::make('email')
                        ->label('Email')
                        ->copyable()
                        ->copyMessage('Copied!')
                        ->copyMessageDuration(1500),
                    TextEntry::make('available')
                        ->label(__('Layanan Tersedia'))
                        ->formatStateUsing(function (bool $state) {
                            return $state ? 'Ya' : 'Tidak';
                        })
                        ->badge()
                        ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                    TextEntry::make('latitude')
                        ->label('Latitude')
                        ->copyable()
                        ->copyMessage('Copied!')
                        ->copyMessageDuration(1500),
                    TextEntry::make('longitude')
                        ->label('Longitude')
                        ->copyable()
                        ->copyMessage('Copied!')
                        ->copyMessageDuration(1500),
                ])
                    ->columns(2)
            ])
            ->record(function (array $arguments) {
                return array_key_exists('model_id', $arguments) ? Pemadam::find($arguments['model_id']) : null;
            })
            //modal edit button
            ->modalFooterActions(
                [
                    Action::make('edit')
                        ->label('Edit Faskes')
                        ->url(fn (Pemadam $pemadam) => route('filament.admin.resources.pemadams.edit', $pemadam->id))
                ]
            )
            ->modalSubmitAction(false);
    }
}
