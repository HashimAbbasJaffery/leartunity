<template>

<li v-if="!is_deleted" ref="content" @click="!content.is_paid ? emit('changeVideo', content.content) : ''" class="px-4 py-3 rounded my-3 flex justify-between item-center" :class="{'cursor-not-allowed': content.is_paid && !instructor}">
    <div class="content-info flex relative" style="height: 78.5px;">
        <div class="thumbnail mr-3 rounded" style="background: var(--primary);">
            <img :src="`/thumbnails/${content.thumbnail}`" alt="" width="150">

            <div class="thumbnail flex justify-center items-center h-full" v-if="content.progress > 0" style="background: rgba(255, 255, 255, 0.5);" :style="{ 'width': content.progress + '%' }">
                <p class="text-white text-xs">{{ Math.round(content.progress) }}%</p>
            </div>

            <time datetime="" v-if="content.duration > 0" class="absolute bottom-0 text-xs text-white p-1" style="background: var(--primary)">{{ secondsToHms(content.duration) }}</time>
        </div>
        <p :class="{'cursor-pointer': !content.is_paid, 'cursor-not-allowed': content.is_paid}">{{ content.title }}</p>
    </div>
    <div class="meta-data flex">
        <div class="content-meta" v-if="!instructor">
            <span class="text-gray-500 text-sm mr-3" v-if="content.is_paid">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-sm" width="24" height="24" viewBox="0 0 24 24"><path d="M17 9.761v-4.761c0-2.761-2.238-5-5-5-2.763 0-5 2.239-5 5v4.761c-1.827 1.466-3 3.714-3 6.239 0 4.418 3.582 8 8 8s8-3.582 8-8c0-2.525-1.173-4.773-3-6.239zm-8-4.761c0-1.654 1.346-3 3-3s3 1.346 3 3v3.587c-.927-.376-1.938-.587-3-.587s-2.073.211-3 .587v-3.587zm3 17c-3.309 0-6-2.691-6-6s2.691-6 6-6 6 2.691 6 6-2.691 6-6 6zm2-6c0 1.104-.896 2-2 2s-2-.896-2-2 .896-2 2-2 2 .896 2 2z"/></svg>
            </span>
            <div>
                <time class="text-gray-500 text-sm" datetime="" v-if="!content.is_paid">{{ secondsToHms(content.duration) }}</time>
            </div>
        </div>
        <div class="action-buttons" v-if="instructor">
            <button :disabled="content.progress > 0" @click="startDeleteContent(content.id)"  class="disabled:bg-red-200 disabled:cursor-not-allowed bg-red-400 hover:bg-red-500 text-white px-2 py-1 rounded mx-2">Delete</button>
            <button :disabled="content.progress > 0" @click="update(content.id)" class="disabled:bg-blue-200 disabled:cursor-not-allowed bg-blue-400 hover:bg-blue-500 text-white px-2 py-1 rounded mx-2">Update</button>
        </div>
    </div>
</li>
</template>
<script setup>

import Modal from '../Classes/Modal';
import {ref} from "vue";

let props = defineProps({
    content: Object,
    instructor: Boolean
});

let is_deleted = ref(false);

const modal = new Modal()
let emit = defineEmits("update");

const deleteContent = async id => {
    const status = await axios.delete(`/instructor/content/${id}/delete`);
    if(status.data === 1) {
        is_deleted.value = true;
        modal.success("Content Deleted!");
    }
}

async function startDeleteContent(id) {
    modal.oneInput(
        "Are you sure you want to delete this content? No Tack-backs!",
        () => deleteContent(id),
        true,
        "Delete",
        ""
    );
}

function addContent(id, action = 1) {
    let modal = new Modal();
    actionType.value = action;
    clickedId.value = id;
    modal.oneInput("Upload Content", successUpload, true, true, "html", uploadPreparation,
    '<input type="text" id="content-title" class="mb-2" style="width: 100%; border: 1px solid var(--primary); resize: none" ><textarea id="content-description" type="text" style="width: 100%; border: 1px solid var(--primary); height: 100px; resize: none" class="mb-2"></textarea> <input id="content-video" style="border: none;width: 100%;" type="file" value="Choose Files"/>', csrf)
}

const update = id => emit("update", id);

function secondsToHms(seconds) {
    const h = Math.floor(seconds / 3600);
    const m = Math.floor((seconds % 3600) / 60);
    const s = seconds % 60;

    let timeString = "";
    if(h > 0) {
        timeString += `${h}:`;
    }
    timeString += `${m}:${s < 10 ? 0 : ''}${s}`;

    return timeString.trim();
}

</script>
