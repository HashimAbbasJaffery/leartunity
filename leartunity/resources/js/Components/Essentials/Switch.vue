<script setup>
import {defineProps, ref, watch} from "vue"
import axios from "axios";
import NavLink from "../NavLink.vue"

defineProps({
    id: Number,
    active: Number
})

let radioButton = ref();

async function changed() {
    alert(radioButton.value.id)
    const status = await axios.put(`/instructor/course/${radioButton.value.id}/status`);
}

</script>
<template>
    <label class="switch" style="position: absolute; left: 13px; top: 10px;">
        <input type="checkbox" @change="changed" ref="radioButton" :checked="active" class="course-switch" :id="id">
        <span class="slider round"></span>
    </label>
</template>
