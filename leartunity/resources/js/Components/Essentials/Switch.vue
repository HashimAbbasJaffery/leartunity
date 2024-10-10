<script setup>
import {defineProps, ref, watch} from "vue"
import axios from "axios";
import NavLink from "../NavLink.vue"

defineProps({
    id: Number,
    active: Number,
    absolute: {
        type: Boolean,
        default: true
    }
})

let radioButton = ref();

async function changed() {
    const status = await axios.put(`/instructor/course/${radioButton.value.id}/status`);
}

</script>
<template>
    <label class="switch" :style="{ 'position': absolute ? 'absolute' : '' }" style="left: 13px; top: 10px;">
        <input type="checkbox" @change="changed" ref="radioButton" :checked="active" class="course-switch" :id="id">
        <span class="slider round"></span>
    </label>
</template>
