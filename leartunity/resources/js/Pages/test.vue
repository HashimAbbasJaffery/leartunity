<script setup>

import { defineProps } from "vue";
import Layout from "../Shared/Layout.vue";
defineProps({
    name: String
})

</script>
<template>
    <Layout>

        <h1 v-if="name === 'Hashim'">{{ name }}</h1>
    </Layout>
</template>
