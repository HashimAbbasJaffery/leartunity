<template>
  <NavLink :href="`/learn/course/${course.slug}/${content.id}`">
    <div class="lesson mb-3" :class="{ 'bg-gray-200 rounded': isWatching}">
    <div class="lesson flex rounded lesson-body" >
        <div class="play-video mr-3 flex align-items justify-center">
            <i class="fa-solid fa-pause" v-if="isWatching"></i>
            <i class="fa-solid fa-check" v-else-if="isWatched"></i>
            <i class="fa-solid fa-play" v-else></i>
        </div>
        <div class="details">

            <h2 style="font-size: 14px;">{{ content.title }}</h2>
            <p style="font-size: 12px;">
                <i class="fa-solid fa-clock mr-1"></i>
                {{ secondsToHms(content.duration) }}
            </p>
        </div>
    </div>
</div>
</NavLink>
</template>

<script setup>
import { secondsToHms } from '../Helpers/Helper';
import NavLink from "../Components/NavLink.vue";
import {inject, computed} from "vue";

let props = defineProps({
    content: Object
})


let course = inject("course");
let current_content = inject("current_content");
let completed = inject("completed");

let isWatching = computed(() => current_content.id === props.content.id);
let isWatched = computed(() => completed.includes(props.content.id));


</script>

<style>

</style>
