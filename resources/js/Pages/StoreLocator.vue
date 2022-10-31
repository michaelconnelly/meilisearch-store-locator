<template>
    <Head :title="title" />
    <div class="w-screen h-screen p-4">
        <div class="flex flex-wrap h-full">
            <main role="main" class="w-full h-full lg:w-3/4">
                <StoreMap />
            </main>
            <aside class="hidden w-full h-full px-2 lg:block lg:w-1/4">
                <StoreSearch @findStores="findStores" />
                <StoreResults class="overflow-y-auto h-4/5" />
            </aside>
        </div>
    </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';
import StoreMap from '@/Components/StoreMap.vue';
import StoreSearch from '@/Components/StoreSearch.vue';
import StoreResults from '@/Components/StoreResults.vue';
import { Inertia } from '@inertiajs/inertia';
import { computed } from 'vue'

export default {
    data() {
        return {
            title: 'Meili Store Locator',
            search: {
                postcode: this.filters.postcode ?? '',
                distance: this.filters.distance ?? 20
            }
        }
    },
    props: {
        stores: Object,
        filters: Object
    },
    provide() {
        return {
            $stores: computed(() => this.stores),
            $search: computed(() => this.search),
        }
    },
    components: {
        Head,
        StoreMap,
        StoreSearch,
        StoreResults,
    },
    methods: {
        findStores() {
            Inertia.get('/store-locator', {
                postcode: this.search.postcode,
                distance: this.search.distance,
            }, {
                preserveState: true
            });
        }
    },
}
</script>
