<script setup>
import {defineProps} from "vue"
defineProps({
    course: Object
})
</script>
<template>
    <div class="course">
        <div class="course-header" style="position: relative;">
                    <label class="switch" style="position: absolute; left: 13px; top: 10px;">
                        <input type="checkbox" class="course-switch" :id="course.id">
                        <span class="slider round"></span>
                    </label>
                    <div style="position: absolute; bottom: 10px; right: 10px;" class="flex">
                        <form class="mr-2" action="#" method="POST" name="courseDelete" id="courseDelete">
                            <button class="text-white px-2 rounded bg-red-500 hover:bg-red-600">Delete</button>
                        </form>
                        <form action="#" name="courseDelete" id="courseDelete">
                            <button class="text-white px-2 rounded bg-blue-500 hover:bg-blue-600">Update</button>
                        </form>
                    </div>
                <div class="course-pill bg-black text-white px-2 py-1 text-xs" style="position: absolute; right: 10px; top: 10px; border-radius: 10px;">
                    <p>Purchased</p>
                </div>
                <img v-if="course.thumbnail" :src="'/course/'+course.thumbnail" style="border-radius: 10px;" height="600" width="400" alt="">
                <img v-if="!course.thumbnail" src="https://placehold.co/600x400" height="600" width="400" alt="">
        </div>
        <a href="">
            <div class="course-instructor mt-4 flex">
                <div class="instructor-img">
                        <img v-if="course.author?.profile" :src="'/profile/'+course.author.profile.profile_pic" height="45" width="45"  class="rounded-full" alt="">
                        <img src="https://placehold.co/45x45" height="45" width="45"  class="rounded-full" alt="">
                </div>
                <div class="instructor-details flex">
                    <h2>Hashim Abbas</h2>
                    <div class="course-rating flex">
                        No Reviews
                    </div>
                </div>
            </div>
        </a>

        <div class="course-detail mt-4">
            <div class="course-description">
                <h1 style="font-size: 15px; font-weight: bold; margin-bottom: 5px;">
                    {{ course.title }}
                </h1>
                {{ course.description.substring(0, 80) }}
            </div>
            <div class="course-options mt-2">
                <a href="#">Enroll</a>
                <a href="#">See Details</a>

                <a href="#">Manage</a>        </div>
            <div class="course-price flex justify-between">
                <p>{{ course.price }} $</p>
                <p>Duration: {{ course.contents_sum_duration }}</p>
            </div>
        </div>
    </div>
</template>
