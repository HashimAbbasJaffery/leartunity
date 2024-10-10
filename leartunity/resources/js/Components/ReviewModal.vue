<template>
    <div v-if="active" class="modal-container bg-black/60 w-full h-full fixed z-50 top-0 flex justify-center items-center">
        <div class="bg-white w-1/2 rounded p-4">
            <h1 class="font-bold text-xl mb-4">Leave an Honest Review</h1>
            <textarea v-model="feedback" id="review" class="w-full rounded resize-none p-2 outline-none" style="height: 200px;" placeholder="Write Review"></textarea>
            <div class="" style="font-size: 25px; text-align: center;">
                <i @click="stars = n" v-for="n in totalStars" :key="n" :class="{ 'fa-solid': n <= stars, 'fa-regular': n > stars }" class="fa-star feedback-star starred" style="cursor: pointer;"></i>
            </div>
            <p class="text-center">{{ messages[stars] }}</p>
            <div class="actions">
                <button @click="$emit('send', [stars, feedback])" class="bg-blue-400 text-white px-4 py-1 rounded mt-3 hover:bg-blue-500">Post</button>
                <button class="ml-3 bg-red-400 text-white px-4 py-1 rounded mt-3 hover:bg-red-500">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script setup>

import {ref} from "vue";

let stars = ref(1);
let feedback = ref("");
let totalStars = 5;

let messages = {
    1: "Poor",
    2: "Not Good",
    3: "Fair",
    4: "Good",
    5: "Awesome!"
}

let props = defineProps({
    active: Boolean,
})

</script>

<style>

</style>
