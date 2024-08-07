<template>
  <div class="course flex" style="position: relative;">
    <div class="course-image mr-5" style="width: 20%">
        <img :src="`/course/${purchase.course.thumbnail}`" height="250" width="250" class="rounded" />
    </div>
    <div class="course-detail" style="width: 80%">
        <h1 class="text-xl mb-2" style="font-weight: 600;">{{ purchase.course?.title ?? "No title" }}</h1>
        <p>{{ purchase.course.description.substring(0, 150) }}...</p>
        <a href="#" style="font-size: 13px;" class="mt-2 mb-2">{{ purchase.course.author.name }}</a>
        <div class="progress mt-2">
            <p style="font-size: 13px; float: right;">{{ getProgress(purchase) }}%</p>
            <div class="progress-bar" style="background: rgb(222, 222, 222); height: 2px;">
                <div class="completed-progress" style="background: var(--primary); height: 2px;" :style="{'width': `${purchase.course.tracker.progress}px`}">&nbsp;</div>
            </div>


            <div class="mt-4 inline-block">
                <a v-if="getProgress(purchase) >= 100" class="highlighted px-4 py-1" href="#">Download Certificate</a>
                <a v-if="getProgress(purchase) >= 50" class="give-review highlighted px-4 py-1 bg-green-500 hover:bg-green-600">Give Review</a>
                <a v-if="getProgress(purchase) >= 50" class="edit-review highlighted px-4 py-1 bg-yellow-500 hover:bg-yellow-600">Edit Review</a>
            </div>
        </div>
    </div>
    <NavLink :href="`learn/course/${purchase.course.slug}/${getFirstContentId(purchase)}`" style="text-align:center; width: 10%;padding: 3px 6px 3px 6px;position: absolute; right: 0px;" class="highlighted">{{ (!getProgress(purchase)) ? "Start" : "Resume" }}</NavLink>
</div>
</template>

<script setup>

import NavLink from './NavLink.vue';

let props = defineProps({
    purchase: Object
})


function getFirstContentId(purchase) {
    return purchase.course.contents[0].id;
}

function getProgress(purchase) {
    return purchase.course.tracker.progress;
}

</script>

<style>

</style>
