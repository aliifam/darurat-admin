{{-- custom label for google map markers just marker from database --}}

<script>
    function filamentGoogleMapsWidget({
        cachedData,
        config,
        mapEl
    }) {
        return {
            cachedData,
            config,
            mapEl,
            map: null,
            markers: [],
            infoWindows: [],
            initMap() {
                this.map = new google.maps.Map(this.mapEl, this.config);
                this.updateMapData();
            },
            updateMapData() {
                this.clearMarkers();
                this.cachedData.forEach((data) => {
                    const marker = new google.maps.Marker({
                        position: data.position,
                        map: this.map,
                        title: data.title,
                        label: data.label,
                    });
                    this.markers.push(marker);
                    const infoWindow = new google.maps.InfoWindow({
                        content: data.infoWindowContent,
                    });
                    this.infoWindows.push(infoWindow);
                    marker.addListener('click', () => {
                        this.infoWindows.forEach((infoWindow) => {
                            infoWindow.close();
                        });
                        infoWindow.open(this.map, marker);
                    });
                });
            },
            clearMarkers() {
                this.markers.forEach((marker) => {
                    marker.setMap(null);
                });
                this.markers = [];
                this.infoWindows = [];
            },
        };
    }
</script>
