<script setup>
import Header from '../Components/Essentials/Header.vue';
import Footer from '../Components/Essentials/Footer.vue';
import FlashMessage from '../Components/Messages/FlashMessage.vue';
import ImportantMessage from '../Components/Messages/ImportantMessage.vue';
import { usePage } from '@inertiajs/vue3';
import { provide } from "vue";

const page = usePage();
const currency = page.props.auth.currency;
provide("currency", currency)


</script>
<template>
    <ImportantMessage>It is very Important message</ImportantMessage>
    <FlashMessage>Logged in!</FlashMessage>
    <Header />
    <slot></slot>
    <Footer />
</template>
