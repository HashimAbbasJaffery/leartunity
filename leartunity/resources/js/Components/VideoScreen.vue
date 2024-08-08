<template>
    <video id="player" class="rounded">
        <!-- Captions are optional -->
    </video>
</template>

<script setup>
import {toRef} from "vue"

let props = defineProps({
    video: String
});

toRef("video");



</script>

<style>

</style>
