<script setup>
import {onMounted, ref} from "vue"
import calculateReviewStars from "../../../public/js/helpers/stars";
import Switch from "./Essentials/Switch.vue";
import NavLink from "./NavLink.vue"
import Instructor from "./Instructor.vue";
import swal from "sweetalert";
import { usePage } from "@inertiajs/vue3";
import PilllMessage from "./Messages/PilllMessage.vue";
import {computed} from "vue"

let props = defineProps({
    course: Object
})

const page = usePage();
const user = page.props.auth.user;
const isOwner = computed(() => user.id === props.course.author_id);


function secondsToHms(seconds) {
  const h = Math.floor(seconds / 3600);
  const m = Math.floor((seconds % 3600) / 60);
  const s = seconds % 60;

  let timeString = "";

  if (h > 0) {
    timeString += `${h} hrs `;
  }
  if (m > 0) {
    timeString += `${m} mins `;
  }
  if(s > 0) {
      timeString += `${s} secs`;
  }

  return timeString.trim();
}

console.log(props.course);

</script>
<template>
    <div class="course">
        <div class="course-header" style="position: relative;">
                    <Switch v-if="isOwner" :active="course.status" :id="course.id"/>
                    <div style="position: absolute; bottom: 10px; right: 10px;" class="flex">
                        <NavLink ref="delButton" method="DELETE" :href="`/instructor/course/${course.slug}/delete`" class="mr-2 text-white px-2 rounded bg-red-500 hover:bg-red-600" as="button">Delete</NavLink>
                        <NavLink :href="`/instructor/course/${course.slug}/edit`" class="text-white px-2 rounded bg-blue-500 hover:bg-blue-600" as="button">Update</NavLink>
                    </div>
                <PilllMessage class="bg-black text-white">Purchased</PilllMessage>
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
                <NavLink v-if="isOwner" :href="`/instructor/course/${course.slug}`">Manage</NavLink>
            </div>
            <div class="course-price flex justify-between">
                <p>{{ course.price }} $</p>
                <p>{{ secondsToHms(course.contents_sum_duration) ? secondsToHms(course.contents_sum_duration) : "No Content Yet!" }}</p>
            </div>
        </div>
    </div>
</template>
