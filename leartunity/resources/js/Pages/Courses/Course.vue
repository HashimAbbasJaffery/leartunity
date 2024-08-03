<template>

<Layout>
        <main>
          <section class="intro-video container mx-auto">
            <div class="flex" v-if="sections.length > 0">
              <div class="video col-span-2" style="position: relative;">
                <div class="relative w-full h-full" style="background-color: black;">
                    <Loader :active="active">Changing...</Loader>
                    <video id="player" ref="screen" playsinline controls data-poster="https://placehold.co/600x400">
                    <source class="video" :src="`/uploads/${video}`" type="video/mp4" />
                    </video>
                </div>
              </div>
              <div class="playlist container mx-auto">
                <div class="container_playlist">
                    <Section :video="introduction" @changeVideo="changeVideo($event)" @expand="expandedSection = $event" v-for="section in sections" :key="section.id" :section="section"></Section>
                </div>
                </div>
              </div>
          </section>
          <section id="course-content" class="container mx-auto" style="position: relative;">
            <div class="course-header">
              <p>{{ course.price }} $</p>
            </div>
            <div class="course-details">
              <div class="course-desc" v-html="description.substring(0, descriptionLen)">
              </div>
                <div class="hide-extra" v-if="isHidden" style="display: flex; align-items:center; justify-content: center;position: absolute; width: 100%; bottom: 0px; background: rgb(2,0,36);
                  background: -moz-linear-gradient(180deg, rgba(2,0,36,0) 0%, rgba(249,249,249,1) 35%, rgba(255,255,255,1) 100%);
                  background: -webkit-linear-gradient(180deg, rgba(2,0,36,0) 0%, rgba(249,249,249,1) 35%, rgba(255,255,255,1) 100%);
                  background: linear-gradient(180deg, rgba(2,0,36,0) 0%, rgba(249,249,249,1) 35%, rgba(255,255,255,1) 100%);
                  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#020024',endColorstr='#ffffff',GradientType=1); height: 200px; width: 105%; right: 5px">
                    <p @click="unHide" class="read-more-description" style="background: var(--primary); color: white; padding: 5px; border-radius: 4px; cursor: pointer;">Show More...</p>
                  </div>
                  <p @click="hide" class="read-more-description flex justify-center items-center mt-4" style="background: var(--primary); color: white; padding: 5px; border-radius: 4px; cursor: pointer; width: 50px;">Hide</p>

            </div>
          </section>

          <section id="instructor" class="course-instruction container mx-auto">
            <div class="course-instructor course-section mt-4 flex">
              <div class="instructor-img">
                    <p>{{ course.author.profile_pic }}</p>
                  <img v-if="course.author?.profile?.profile_pic ?? false" :src="`/profile/${ course.author?.profile?.profile_pic ?? false }`" height="45" width="45" class="rounded-full" alt="">
                  <img v-if="!course.author?.profile?.profile_pic ?? false" src="https://placehold.co/45x45" class="rounded-full" alt="">
              </div>
              <div class="instructor-details flex">
                <h2>{{ course.author.name }}</h2>
                <p>courses: {{ courses_count }}</p>
              </div>
            </div>
            <div class="instructor-info">
              <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam, iusto omnis. Id unde eligendi optio voluptatibus? Fuga repellendus hic fugiat iure, consequatur non, explicabo excepturi exercitationem repudiandae placeat quo harum?</p>
              <div class="option">
                <a class="highlighted course-highlighted mr-2">Contact me</a>
                <a href="#" style="background: transparent; color: black; border: 1px solid black;" class="highlighted course-highlighted">Profile</a>
              </div>
            </div>
          </section>

          <section id="reviews" class="container mx-auto">
            <div class="review-header">
              <h1>Reviews</h1>
              <div class="stars">
                <div class="course-rating flex">


                  <p class="ml-1" v-html="calculateReviewStars(course.reviews?.stars) + ` (${course.reviews?.stars})` ?? null"></p>
                </div>
              </div>
            </div>
            <div class="review" v-for="review in reviews.data" :key="review.id">
                <div>
                    <div class="course-instructor mt-4 flex">
                        <div class="instructor-img">
                            <img width="45" src="https://placehold.co/45x45" class="rounded-full" alt="">
                        </div>
                        <div class="instructor-details flex">
                            <h2>{{ review.name }}</h2>
                            <div class="course-rating flex" v-html="calculateReviewStars(review.stars)"></div>
                        </div>
                    </div>
                    <p style="font-size: 13px;" class="mt-2">{{ review.review }}</p>
                </div>
            </div>

          </section>
            <p class="container mx-auto mb-2"></p>

        </main>
</Layout>

</template>

<script setup>
import Layout from "../../Shared/Layout.vue"
import calculateReviewStars from "../../../../public/js/helpers/stars";
import {ref, provide} from "vue"
import Section from "../../Components/Section.vue";
import Loader from "../../Components/Essentials/Loading.vue"

let props = defineProps({
    course: Object,
    reviews: Array,
    sections: Array,
    courses_count: Number,
    introduction: String
})

let expandedSection = ref();
provide("expanded", expandedSection)


let isHidden = ref(true)
let descriptionLen = ref(1500);
let video = ref(props.introduction);
let screen = ref();
let active = ref(false);


let description = props.course.description + "<h1>Pre Requisites</h1>" + props.course.pre_req;

function unHide() {
    descriptionLen.value = Infinity;
    isHidden.value = false;
}
function hide() {
    descriptionLen.value = 1500;
    isHidden.value = true;
}

function changeVideo(src) {
    active.value = true;
    video.value = src;
    screen.value.load();
    setTimeout(() => {
        active.value = false;
    }, 1400)
}



</script>

<style>

</style>
