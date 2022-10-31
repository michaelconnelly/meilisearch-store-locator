<template>
    <div id="map" class="w-full h-full rounded-xl"></div>
</template>

<script>
    export default {
        inject: [
            '$stores'
        ],
        data() {
            return {
                stores: this.$stores,
                map: Object,
                markersLayer: Object,
            }
        },
        watch: {
            stores(stores) {
                this.clearMarkers();
                this.renderMarkers(stores);
            }
        },
        mounted() {
            this.renderMap();
            this.renderMarkers();
        },
        methods: {
            renderMap() {
                this.map = L.map("map", {
                    center: [53.438889, -2.966389],
                    zoom: 16,
                });

                this.markersLayer = new L.layerGroup();

                this.markersLayer.addTo(this.map)

                L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    maxZoom: 19,
                    attribution: "&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>"
                }).addTo(this.map);
            },
            renderMarkers() {
                this.markersLayer.clearLayers()

                this.stores.data?.map((store) => {
                    L.marker(store.location).addTo(this.markersLayer).bindTooltip(store.client);
                })

                if(this.stores.data?.length > 0) {
                    this.map.fitBounds(this.stores.data.map((store) => store.location), {
                        maxZoom: 16
                    });
                }
            },
            clearMarkers() {
                this.markersLayer.clearLayers();
            }
        }
    }
</script>
