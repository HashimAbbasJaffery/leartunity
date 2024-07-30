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
    <div v-if="active" class="notification animate__animated">
      <p class="notification-message"><slot></slot></p>
    </div>
</template>


