<?php

namespace App\Filament\Resources\FaskesResource\Widgets;

use App\Models\Faskes;
use Cheesegrits\FilamentGoogleMaps\Widgets\MapWidget;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class FaskesMap extends MapWidget
{
    protected static ?string $heading = 'Peta Fasilitas Kesehatan';

    protected int | string | array $columnSpan = '2';

    protected static ?string $markerAction = 'markerAction';

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

                // 'label' => view(
                //     'widgets.label',
                //     [
                //         'label' => $location->nama,
                //         'url' => route('filament.admin.resources.faskes.edit', $location->id),
                //         'type' => $location->jenis,
                //     ]
                // )->render(),
                'label' => $location->nama,

                'id' => $location->getKey(),

                /**
                 * Optionally you can provide custom icons for the map markers,
                 * either as scalable SVG's, or PNG, which doesn't support scaling.
                 * If you don't provide icons, the map will use the standard Google marker pin.
                 */
                'icon' => [
                    // 'url' => url('images/location.png'),
                    'url' => url('images/ambulan.png'),
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
            ->label('Detail Fasilitas Kesehatan')
            ->infolist([
                Section::make([
                    TextEntry::make('nama'),
                    TextEntry::make('jenis')
                        ->formatStateUsing(function (string $state) {
                            if ($state == 'rumah_sakit') {
                                return 'Rumah Sakit';
                            } else {
                                return ucfirst($state);
                            }
                        })
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'rumah_sakit' => 'success',
                            'klinik' => 'info',
                            'puskesmas' => 'danger'
                        }),
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
                return array_key_exists('model_id', $arguments) ? Faskes::find($arguments['model_id']) : null;
            })
            //modal edit button
            ->modalFooterActions(
                [
                    Action::make('edit')
                        ->label('Edit Faskes')
                        ->url(fn (Faskes $faskes) => route('filament.admin.resources.faskes.edit', $faskes->id))
                ]
            )
            ->modalSubmitAction(false);
    }
}
