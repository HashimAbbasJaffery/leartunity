<script setup>
import {defineProps} from "vue";
defineProps({
    active: {
        type: Boolean,
        default: false
    }
})
</script>
<template>

    <div v-if="active" id="confirm-email">
        <slot></slot>
    </div>
</template>

<style scoped>
#confirm-email {
    text-align: center;
    padding: 0px;
    background: red;
    color: white;
    position: fixed;
    bottom: 0px;
    z-index: 2;
    width: 100%;
}
</style>
