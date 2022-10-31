<template>
    <div class="flex flex-col w-full gap-4">
        <div v-for="store in stores.data" :key="store" class="flex justify-between p-2 text-sm border rounded-lg">
            <div>
                <p>{{ store.client }}</p>
                <p class="text-xs">{{ store.postcode }}</p>
            </div>
            <div>
                <p>Distance</p>
                <p>{{ store.distance }}km</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        inject: [
            '$stores'
        ],
        data() {
            return {
                stores: this.$stores
            }
        }
    }
</script>
