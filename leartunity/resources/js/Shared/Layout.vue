<script setup>
import Header from '../Components/Essentials/Header.vue';
import Footer from '../Components/Essentials/Footer.vue';
import FlashMessage from '../Components/Messages/FlashMessage.vue';
import ImportantMessage from '../Components/Messages/ImportantMessage.vue';
</script>
<template>
    <ImportantMessage>It is very Important message</ImportantMessage>
    <FlashMessage>Logged in!</FlashMessage>
    <Header />
    <slot></slot>
    <Footer />
</template>
