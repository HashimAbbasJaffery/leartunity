<template>
      <input type="submit" :value="value" class="mt-3"  :class="{'light': lighted}" style="cursor: pointer;width: 100%; border-radius: 5px; font-size: 14px;" />
</template>

<script setup>
import {defineProps} from "vue";

defineProps({
    value: String,
    lighted: Boolean
})
</script>

<style scoped>
.light {
    background: transparent;
    color: black
}
</style>

