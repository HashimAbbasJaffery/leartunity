<template>
    <slot></slot>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { provide, ref, watch } from "vue";
import { useLocaleStore } from '../Stores/LocaleStore';


const page = usePage();
const currency = ref(page.props.auth.currency);

const localeStore = useLocaleStore();
const supportedCurrencies = page.props.supported.currencies;
localeStore.setLocaleData(supportedCurrencies);



provide("localeData", localeStore.localeData);
provide("currency", currency)
let unit = ref(currency.value.unit ?? "$");
provide("unit", unit);
let locale = ref(currency.id);
provide("locale", locale);

watch(locale, function() {
    currency.value = localeStore.localeData.filter(data => data.id == locale.value);
})

provide("test", "test");



</script>

<style>

</style>
