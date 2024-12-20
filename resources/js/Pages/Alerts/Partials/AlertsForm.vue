<script setup>
import {ref} from 'vue';
import {Link, router, useForm} from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SuccessButton from '@/Components/SuccessButton.vue';
import Select from '@/Components/Select.vue';
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    user: Object,
    countries: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    _method: 'POST',
    user_id: props.user.id,
    alerts: props.user.alerts,
});

const update = (alert) => {
    alert.errors = null
    axios.post(route('alerts.update'), {
        id: alert.id,
        country_id: alert.country_id,
        city_id: alert.city_id,
        uvi: alert.uvi,
        precipitation: alert.precipitation,
        creating: alert.creating || false,
        updating: alert.updating || false,
    }).then((response) => {
        if (!alert.id) alert.id = response.data
        alert.updating = false
        alert.creating = false
    }).catch((error) => {
        alert.errors = error.response.data.errors
    })
};

const add = () => {
    form.alerts.push({
        id: null,
        country_id: null,
        city_id: null,
        uvi: null,
        precipitation: null,
        creating: true,
    })
};

const remove = (alert, index) => {
    if(alert.id) axios.delete(route('alerts.delete', {id: alert.id}))
    form.alerts.splice(index, 1)
};

const getCities = (alert) => {
    alert.city_id = null
    axios.post(route('alerts.getCities'), {
        country_id: alert.country_id
    }).then(function (response) {
        alert.cities = response.data.cities
    })
};
</script>

<template>
    <FormSection>
        <template #title>
            Weather Alerts
        </template>

        <template #description>
            Add country and city to receive severe weather alerts.
        </template>

        <template #form>

            <!-- Alert -->
            <div class="col-span-6 flex border border-gray-200 p-6 sm:rounded-md" v-for="(alert, index) in form.alerts">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2 mt-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5"/>
                </svg>

                <div class="flex flex-col flex-1 pl-4 items-baseline space-y-6">

                    <!-- Country -->
                    <div class="w-full">
                        <InputLabel for="country" value="Country"/>
                        <Select
                            id="country"
                            v-model="alert.country_id"
                            class="mt-1 block w-full"
                            @change="getCities(alert)"
                            :options="alert.country ? [{id: alert.country.id, name: alert.country.name}] : props.countries"
                            :disabled="alert.id ? 'disabled' : null"
                        />
                        <InputError v-if="alert.errors && alert.errors.country_id" :message="alert.errors.country_id[0]" class="mt-2"/>
                    </div>

                    <!-- City -->
                    <div class="w-full">
                        <InputLabel for="city" value="City"/>
                        <Select
                            id="city"
                            v-model="alert.city_id"
                            class="mt-1 block w-full"
                            :options="alert.city ? [{id: alert.city.id, name: alert.city.name}] : alert.cities"
                            :disabled="alert.id ? 'disabled' : null"
                        />
                        <InputError v-if="alert.errors && alert.errors.city_id" :message="alert.errors.city_id[0]" class="mt-2"/>
                    </div>

                    <!-- UVIndex -->
                    <div class="w-full">
                        <InputLabel for="uvi" value="UV Index Level"/>
                        <Select
                            id="uvi"
                            v-model="alert.uvi"
                            class="mt-1 block w-full"
                            @change="alert.updating = true"
                            :options="[
                                {id: 'low', name: 'low'},
                                {id: 'moderate', name: 'moderate'},
                                {id: 'high', name: 'high'}
                            ]"
                        />
                        <InputError v-if="alert.errors && alert.errors.uvi" :message="alert.errors.uvi[0]" class="mt-2"/>
                    </div>

                    <!-- Precipitation -->
                    <div class="w-full">
                        <InputLabel for="precipitation" value="Precipitation Level"/>
                        <Select
                            id="precipitation"
                            v-model="alert.precipitation"
                            class="mt-1 block w-full"
                            @change="alert.updating = true"
                            :options="[
                                {id: 'dry', name: 'dry'},
                                {id: 'low', name: 'low'},
                                {id: 'moderate', name: 'moderate'},
                                {id: 'high', name: 'high'},
                                {id: 'very_high', name: 'very_high'},
                                {id: 'extreme', name: 'extreme'}
                            ]"
                        />
                        <InputError v-if="alert.errors && alert.errors.precipitation" :message="alert.errors.precipitation[0]" class="mt-2"/>
                    </div>

                    <div class="ml-auto space-x-2">
                        <DangerButton type="button" @click="remove(alert, index)">
                            Delete
                        </DangerButton>

                        <SuccessButton v-if="alert.updating || alert.creating" type="button" class="ml-auto" @click="update(alert)">
                            {{ alert.id ? 'Update' : 'Save' }}
                        </SuccessButton>
                    </div>

                </div>

            </div>

            <PrimaryButton type="button" @click="add" class="col-span-6 justify-center py-3">
                <span>Add Alert</span>
            </PrimaryButton>
        </template>
    </FormSection>
</template>
