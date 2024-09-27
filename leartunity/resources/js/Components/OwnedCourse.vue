<template>
  <div class="course flex" v-el:mainDiv style="position: relative;">
    <div class="course-image mr-5" style="width: 20%">
        <img :src="`/course/${purchase.course.thumbnail}`" height="250" width="250" class="rounded" />
    </div>
    <div class="course-detail" style="width: 80%">
        <h1 class="text-xl mb-2" style="font-weight: 600;">{{ purchase.course?.title ?? "No title" }}</h1>
        <p>{{ purchase.course.description.substring(0, 150) }}...</p>
        <a href="#" style="font-size: 13px;" class="mt-2 mb-2">{{ purchase.course.author.name }}</a>
        <div class="progress mt-2">
            <p style="font-size: 13px; float: right;">{{ (getProgress(purchase) >= 100) ? $t('Completed!') : getProgress(purchase) + "%" }}</p>
            <div class="progress-bar" style="background: rgb(222, 222, 222); height: 2px;">
                <div class="completed-progress" style="background: var(--primary); height: 2px;" :style="{'width': `${purchase.course.tracker.progress}%`}">&nbsp;</div>
            </div>


            <div class="mt-4 inline-block space-x-3">
                <a target="_blank" :href="`/learn/certificate/${purchase.certificate.certificate_id}`" v-if="getProgress(purchase) >= 100" class="highlighted px-4 py-1" v-translate>View Certificate</a>
                <a @click="giveReview" v-if="getProgress(purchase) >= 50" class="give-review highlighted px-4 py-1 bg-green-500 hover:bg-green-600" v-translate>Give Review</a>
                <!-- <a v-if="getProgress(purchase) >= 50" class="edit-review highlighted px-4 py-1 bg-yellow-500 hover:bg-yellow-600">Edit Review</a> -->
            </div>
        </div>
    </div>
    <h1 ref="lol">jdfhjdf</h1>
    <NavLink :href="`learn/course/${purchase.course.slug}/${getFirstContentId(purchase)}`" style="text-align:center; padding: 3px 6px 3px 6px;position: absolute; right: 0px;" class="highlighted" v-translate>{{ (!getProgress(purchase)) ? "Start" : "Resume" }}</NavLink>
</div>
</template>

<script setup>

import NavLink from './NavLink.vue';
import Modal from '../Classes/Modal';
import {ref} from "vue";

let lol = ref();
console.log(lol);

let props = defineProps({
    purchase: Object
});

function getFirstContentId(purchase) {
    return purchase.course.contents[0].id;
}

function getProgress(purchase) {
    return purchase.course.tracker.progress;
}


function giveReview() {
    let html = `<div class="" style="font-size: 25px;">
                    <i class="fa-solid fa-star feedback-star starred" data-star="1" onmouseover="mouseoverStar()" style="cursor: pointer;"></i>
                    <i class="fa-regular fa-star feedback-star" data-star="2" onmouseover="mouseoverStar()" style="cursor: pointer;"></i>
                    <i class="fa-regular fa-star feedback-star" data-star="3" onmouseover="mouseoverStar()" style="cursor: pointer;"></i>
                    <i class="fa-regular fa-star feedback-star" data-star="4" onmouseover="mouseoverStar()" style="cursor: pointer;"></i>
                    <i class="fa-regular fa-star feedback-star" data-star="5" onmouseover="mouseoverStar()" style="cursor: pointer;"></i>
                </div>`
    let modal = new Modal();
    modal.oneInput("Leave an honest Review!", function() {

    }, true, "Save", "html", false, html);
}


</script>

<style>

</style>
