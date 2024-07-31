<template>
<div>
    <h1>{{ title }}</h1>
    <slot />
</div>
</template>

<script setup>
import {defineProps} from "vue"

defineProps({
    title: String
})
</script>

<style>

</style>
