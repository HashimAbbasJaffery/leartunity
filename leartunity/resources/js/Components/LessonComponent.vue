<template>
  <a href="#">
    <div class="lesson mb-3">
    <div class="lesson flex rounded lesson-body" >
        <div class="play-video mr-3 flex align-items justify-center">
            <i class="fa-solid fa-check"></i>
            <i class="fa-solid fa-pause"></i>
            <i class="fa-solid fa-play"></i>
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
</a>
</template>

<script setup>
import { secondsToHms } from '../Helpers/Helper';

let props = defineProps({
    content: Object
})



</script>

<style>

</style>
