<template>
    <div class="flex flex-wrap items-center gap-2 mb-8">
        <div class="w-full">
            <InputLabel for="postcode" value="Postcode" />
            <TextInput placeholder="Enter Postcode" id="postcode" type="text" class="block w-full" v-model="search.postcode" />
            <InputError class="mt-2" :message="errors.postcode" />
        </div>
        <div class="flex items-center w-full gap-2 justify-evenly">
            <InputLabel for="distance" value="Distance" />
            <input type="range" min="0" max="100" class="flex-grow" v-model="search.distance">
            <InputLabel for="postcode" :value="search.distance" />km
        </div>
        <div class="flex w-full">
            <PrimaryButton @click="findStores" class="ml-auto">Search</PrimaryButton>
        </div>
    </div>
</template>

<script>
    import TextInput from '@/Components/TextInput.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';

    export default {
        inject: [
            '$search'
        ],
        data() {
            return {
                search: this.$search,
                errors: {
                    postcode: ''
                }
            };
        },
        components: {
            TextInput,
            PrimaryButton,
            InputError,
            InputLabel,
        },
        methods: {
            findStores() {
                this.errors.postcode = null;

                if(!this.search.postcode) {
                    this.errors.postcode = "Postcode Required"
                    return;
                }

                this.$emit('findStores')
            }
        },
    }
</script>
