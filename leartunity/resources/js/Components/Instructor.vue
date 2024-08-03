<script setup>
import {defineProps} from "vue"
import calculateReviewStars from "../../../public/js/helpers/stars";

defineProps({
    image: {
        type: String,
        default: null
    },
    name: String,
    rating: String
})
</script>

<template>
    <a href="">
        <div class="course-instructor mt-4 flex">
            <div class="instructor-img">
                <img v-if="image" :src="'/profile/'+image" height="45" width="45"  class="rounded-full" alt="">
                <img v-if="!image" src="https://placehold.co/45x45" height="45" width="45"  class="rounded-full" alt="">
            </div>
            <div class="instructor-details flex">
                <h2>Hashim Abbas</h2>
                <div class="course-rating flex" v-html="calculateReviewStars(rating)">
                </div>
            </div>
        </div>
    </a>
</template>
