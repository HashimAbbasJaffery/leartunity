<script setup>
import {onMounted, ref} from "vue"
import calculateReviewStars from "../../../public/js/helpers/stars";
import Switch from "./Essentials/Switch.vue";
import NavLink from "./NavLink.vue"
import Instructor from "./Instructor.vue";
import swal from "sweetalert";

let props = defineProps({
    course: Object
})




</script>
<template>
    <div class="course">
        <div class="course-header" style="position: relative;">
                    <Switch :active="course.status" :id="course.id"/>
                    <div style="position: absolute; bottom: 10px; right: 10px;" class="flex">
                        <NavLink ref="delButton" method="DELETE" :href="`/instructor/course/${course.slug}/delete`" class="mr-2 text-white px-2 rounded bg-red-500 hover:bg-red-600" as="button">Delete</NavLink>

                        <NavLink :href="`/instructor/course/${course.slug}/edit`" class="text-white px-2 rounded bg-blue-500 hover:bg-blue-600" as="button">Update</NavLink>
                    </div>
                <div class="course-pill bg-black text-white px-2 py-1 text-xs" style="position: absolute; right: 10px; top: 10px; border-radius: 10px;">
                    <p>Purchased</p>
                </div>
                <img v-if="course.thumbnail" :src="'/course/'+course.thumbnail" style="border-radius: 10px;" height="600" width="400" alt="">
                <img v-if="!course.thumbnail" src="https://placehold.co/600x400" height="600" width="400" alt="">
        </div>
        <Instructor href="#" :image="course.author?.profile?.profile_pic ?? null" :name="course.author.name" :rating="props.course.reviews?.stars ?? null"/>

        <div class="course-detail mt-4">
            <div class="course-description">
                <h1 style="font-size: 15px; font-weight: bold; margin-bottom: 5px;">
                    {{ course.title }}
                </h1>
                {{ course.description.substring(0, 80) }}
            </div>
            <div class="course-options mt-2 space-x-2">
                <NavLink href="#">Enroll</NavLink>
                <NavLink :href="`/course/${course.slug}`">See Details</NavLink>
                <NavLink :href="`/instructor/course/${course.slug}`">Manage</NavLink>
            </div>
            <div class="course-price flex justify-between">
                <p>{{ course.price }} $</p>
                <p>Duration: {{ course.contents_sum_duration }}</p>
            </div>
        </div>
    </div>
</template>
