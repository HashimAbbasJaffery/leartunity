<template>
    <p>{{ stars }}</p>
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
    <NavLink v-if="hasCourses" :href="`learn/course/${purchase.course.slug}/${getFirstContentId(purchase)}`" style="text-align:center; padding: 3px 6px 3px 6px;position: absolute; right: 0px;" class="highlighted" v-translate>{{ (!getProgress(purchase)) ? "Start" : "Resume" }}</NavLink>
</div>
</template>

<script setup>

import NavLink from './NavLink.vue';
import Modal from '../Classes/Modal';
import {ref} from "vue";

let hasCourses = ref(true);
const stars = ref(1);


let props = defineProps({
    purchase: Object
});

function getFirstContentId(purchase) {
    let contents = purchase.course.contents;
    if(!contents.length) {
        hasCourses.value = false;
    } else {
        return contents[0]?.id ;
    }
}

function getProgress(purchase) {
    return purchase.course.tracker.progress;
}


function giveReview() {
    let stars = 1;
    let html = `<div class="" style="font-size: 25px;">
                    <i class="fa-solid fa-star feedback-star starred" data-star="1" onclick="${stars = 5}" style="cursor: pointer;"></i>
                    <i class="fa-regular fa-star feedback-star" data-star="2" onclick="${stars = 5}" style="cursor: pointer;"></i>
                    <i class="fa-regular fa-star feedback-star" data-star="3" onclick="${stars = 5}" style="cursor: pointer;"></i>
                    <i class="fa-regular fa-star feedback-star" data-star="4" onclick="${stars = 5}" style="cursor: pointer;"></i>
                    <i class="fa-regular fa-star feedback-star" data-star="5" onclick="${stars = 5}" style="cursor: pointer;"></i>
                </div>`
    let modal = new Modal();
    modal.oneInput("Leave an honest Review!", function() {

    }, true, "Save", "html", false, html);
}


</script>

<style>

</style>
