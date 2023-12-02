<?php

namespace App\Filament\Resources\FaskesResource\Widgets;

use App\Models\Faskes;
use Cheesegrits\FilamentGoogleMaps\Widgets\MapWidget;

class FaskesMap extends MapWidget
{
    protected static ?string $heading = 'Peta Fasilitas Kesehatan';

    protected int | string | array $columnSpan = '2';


    protected static ?int $sort = 1;

    //widget fullwidth

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
        $locations = \App\Models\Faskes::all();

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

                'label' => view(
                    'widgets.label',
                    [
                        'label' => $location->nama,
                        'url' => route('filament.admin.resources.faskes.edit', $location->id),
                        'type' => $location->jenis,
                    ]
                )->render(),

                'id' => $location->getKey(),

                /**
                 * Optionally you can provide custom icons for the map markers,
                 * either as scalable SVG's, or PNG, which doesn't support scaling.
                 * If you don't provide icons, the map will use the standard Google marker pin.
                 */
                'icon' => [
                    'url' => url('images/location.png'),
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
            ->label('Details')
            ->infolist([
                Section::make([
                    TextEntry::make('name'),
                    TextEntry::make('street'),
                    TextEntry::make('city'),
                    TextEntry::make('state'),
                    TextEntry::make('zip'),
                    TextEntry::make('formatted_address'),
                ])
                    ->columns(3)
            ])
            ->record(function (array $arguments) {
                return array_key_exists('model_id', $arguments) ? Faskes::find($arguments['model_id']) : null;
            })
            ->modalSubmitAction(false);
    }
}
