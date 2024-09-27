<script setup>
import Header from '../Components/Essentials/Header.vue';
import Footer from '../Components/Essentials/Footer.vue';
import FlashMessage from '../Components/Messages/FlashMessage.vue';
import ImportantMessage from '../Components/Messages/ImportantMessage.vue';
import Wrapper from "../Components/Wrapper.vue"

</script>
<template>
    <Wrapper>
        <ImportantMessage>It is very Important message</ImportantMessage>
        <FlashMessage>Logged in!</FlashMessage>
        <Header />
            <slot></slot>
        <Footer />
    </Wrapper>
</template>
