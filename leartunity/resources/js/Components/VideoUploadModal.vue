<template>
    <div v-if="active" class="modal-container bg-black/60 w-full h-full fixed z-50 top-0 flex justify-center items-center">
        <div class="bg-white w-1/2 rounded p-4">
            <h1 class="font-bold text-xl mb-4">Upload Video Content</h1>
            <input type="text"  v-model="title" name="title" class="w-full mb-3 rounded" placeholder="Video Title" id="">
            <textarea v-model="description" id="review" class="mb-3 w-full rounded resize-none p-2 outline-none" style="height: 200px;" placeholder="Write Description"></textarea>
            <input @change="uploadPreparation" ref="imageUploader" type="file" name="video" id="">
            <div class="actions">
                <button @click="$emit('upload', [ title, description ])" class="bg-blue-400 text-white px-4 py-1 rounded mt-3 hover:bg-blue-500">Upload</button>
                <button class="ml-3 bg-red-400 text-white px-4 py-1 rounded mt-3 hover:bg-red-500">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script setup>

import { emit } from "cropperjs";
import {ref} from "vue";

let title = ref("");
let description = ref("");

let props = defineProps({
    active: Boolean,
    resumable: {
        type: Array,
        default: null
    }
})


let resumable = ref(props.resumable);
let imageUploader = ref();

function uploadPreparation() {
    setTimeout(() => {
        resumable.value.resumable.assignBrowse(imageUploader.value);
    }, 0)
}

</script>

<style>

</style>
