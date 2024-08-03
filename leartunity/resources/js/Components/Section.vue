<template>
  <div>
        <button class="accordion rounded my-2" :class="{'is-open': expand}" @click="sectionExpand" style="border: 1px solid black;">{{ section.section_name }}</button>

        <div v-if="expand">
            <ul class="ml-5" v-for="content in contents" :key="content.id">
                <li ref="content" @click="!content.is_paid ? emit('changeVideo', content.content) : ''" class="px-4 py-3 bg-gray-300 rounded my-3 flex justify-between item-center" :class="{'cursor-not-allowed': content.is_paid && !instructor}">
                    <p :class="{'cursor-pointer': !content.is_paid, 'cursor-not-allowed': content.is_paid}">{{ content.title }}</p>
                    <div class="meta-data flex">
                        <div class="content-meta" v-if="!instructor">
                            <span class="text-gray-500 text-sm mr-3" v-if="content.is_paid">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-sm" width="24" height="24" viewBox="0 0 24 24"><path d="M17 9.761v-4.761c0-2.761-2.238-5-5-5-2.763 0-5 2.239-5 5v4.761c-1.827 1.466-3 3.714-3 6.239 0 4.418 3.582 8 8 8s8-3.582 8-8c0-2.525-1.173-4.773-3-6.239zm-8-4.761c0-1.654 1.346-3 3-3s3 1.346 3 3v3.587c-.927-.376-1.938-.587-3-.587s-2.073.211-3 .587v-3.587zm3 17c-3.309 0-6-2.691-6-6s2.691-6 6-6 6 2.691 6 6-2.691 6-6 6zm2-6c0 1.104-.896 2-2 2s-2-.896-2-2 .896-2 2-2 2 .896 2 2z"/></svg>
                            </span>
                            <time class="text-gray-500 text-sm" datetime="" v-if="!content.is_paid">{{ secondsToHms(content.duration) }}</time>
                        </div>
                        <div class="action-buttons" v-if="instructor">
                            <button @click="deleteContent(content.id)"  class="bg-red-400 hover:bg-red-500 text-white px-2 py-1 rounded mx-2">Delete</button>
                            <button @click="addContent" class="bg-blue-400 hover:bg-blue-500 text-white px-2 py-1 rounded mx-2">Update</button>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="options ml-5" style="display: flex;" v-if="instructor">
                    <a href="#" id="contents-1"
                        @click="addContent"
                        class="create-content create-course rounded text-center py-2"
                        style="width:100%; display: inline-block">
                        <i class="fa-solid fa-plus p-3 rounded-full"
                            style="background: var(--primary); color: white;"></i>
                    </a>
                    <a href="#" id="contents-1"
                        style="width:100%; display: inline-block; width: 10%; margin-left: 1%; display: flex; align-items: center; justify-content: center; border-color: #9370DB; color: #9370DB;"
                        class="create-content create-course rounded text-center py-2"
                    >
                        Add Quiz
                    </a>
            </div>
        </div>
    </div>
</template>

<script setup>

import {ref, inject, watch} from "vue"
import Modal from "../Classes/Modal";
import NavLink from "../Components/NavLink.vue"
import axios from "axios";





let props = defineProps({
    section: Array,
    instructor: {
        type: Boolean,
        default: false
    },
    resumable: {
        type: Array,
        default: null
    }
})

let contents = ref(props.section.contents)

async function deleteContent(id) {
    try {
        const data = await axios.delete(`/instructor/content/${id}/delete`);
        contents.value = data.data
        console.log(contents.value)
    } catch(err) {
        console.log(err);
    }
}

let expand = ref(false);

let emit = defineEmits(["expand", "changeVideo"])


function sectionExpand() {
    expand.value = !expand.value
    if(expand.value) {
        emit("expand", props.section.section_name)
    }
}

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
  timeString += `${s} secs`;

  return timeString.trim();
}

let expandedSection = inject("expanded");
let video = inject("video");


watch(expandedSection, function() {
    if((props.section.section_name != expandedSection.value) && expand.value) {
        expand.value = false;
    }
})

function successUpload() {
    const content = document.getElementById("content-video");
    const title = document.getElementById("content-title").value;
    const description = document.getElementById("content-description").value;
    props.resumable.resumable.opts.query = {
        ...props.resumable.resumable.opts.query,
        title,
        description
    }
    props.resumable.resumable.opts.target = `/instructor/content/${props.section.id}/update`
    const data = new FormData();
    data.append("content", content.files[0])
    data.append("title", title.value);
    data.append("description", description);

    props.resumable.resumable.upload();


}
function uploadPreparation() {
    setTimeout(() => {
        const content = document.getElementById("content-video");
        props.resumable.resumable.assignBrowse(content);
    }, 0)
}

let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function addContent() {
    let modal = new Modal();
    modal.oneInput("Upload Content", successUpload, true, true, "html", uploadPreparation,
    '<input type="text" id="content-title" class="mb-2" style="width: 100%; border: 1px solid var(--primary); resize: none" ><textarea id="content-description" type="text" style="width: 100%; border: 1px solid var(--primary); height: 100px; resize: none" class="mb-2"></textarea> <input id="content-video" style="border: none;width: 100%;" type="file" value="Choose Files"/>', csrf)
}
</script>

<style>

</style>
