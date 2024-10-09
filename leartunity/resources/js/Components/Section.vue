<template>
  <div>
        <button class="accordion rounded my-2" :class="{'is-open': expand}" @click="sectionExpand" style="border: 1px solid black;">{{ section.section_name }}</button>

        <div v-if="expand">
            <ul class="ml-5" v-for="content in contents" :key="content.id">
                <Content @update="addContent($event, 2)" :content="content" :instructor="instructor"></Content>
            </ul>

            <ul class="ml-5 mb-3" v-if="is_uploading">
                <li class="flex">
                    <div class="content-info mr-3 flex relative" style="height: 78.5px; width: 150px; background: var(--primary);">
                        <div class="thumbnail flex justify-center items-center" style="background: rgba(255, 255, 255, 0.5);" :style="{ 'width': progress + '%' }">
                            <p class="text-white text-xs">{{ Math.round(progress) }}%</p>
                        </div>
                    </div>
                    <p>{{ uploadingTitle }}</p>
                </li>
            </ul>


            <div class="options ml-5" style="display: flex;" v-if="instructor">
                    <a href="#" id="contents-1"
                        @click="addContent(section.id)"
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

import {ref, inject, watch, computed} from "vue"
import Modal from "../Classes/Modal";
import Content from "./Content.vue";
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
let progress = ref(0);
let uploadingTitle = ref("");
let is_uploading = ref(false);
let expand = ref(false);
let hasFile = ref(false);
let actionType = ref(1);
let clickedId = ref();

let emit = defineEmits(["expand", "changeVideo"])

let isAddingContent = computed(() => actionType.value === 1);

function sectionExpand() {
    expand.value = !expand.value
    if(expand.value) {
        emit("expand", props.section.section_name)
    }
}

const withoutFileUpload = async (url, title, description) => {
    const status = await axios.post(url, { title, description });
    contents.value.map(content => {
        let isNotSameContent = status.data.id !== content.id;
        if(isNotSameContent) return;
        content.title = title;
        content.description = description;
    });
}
const successUpload = () => {
    const content = document.getElementById("content-video");
    const title = document.getElementById("content-title").value;
    const description = document.getElementById("content-description").value;
    let isEveryFieldFilled = title && description;
    if(!isEveryFieldFilled) return;
    const url = `/instructor/content/${clickedId.value}/${isAddingContent.value == 1 ? 'add' : 'update'}`;

    // If no video file is attached
    if(!hasFile.value) {
        withoutFileUpload(url, title, description);
        return;
    }

    if(isAddingContent.value) {
        uploadingTitle.value = title;
        is_uploading.value = true;
    }

    props.resumable.resumable.opts.query = {
        ...props.resumable.resumable.opts.query,
        title,
        description
    }
    props.resumable.resumable.opts.target = url;
    const data = new FormData();

    data.append("content", content.files[0]);
    data.append("title", title.value);
    data.append("description", description);

    props.resumable.resumable.upload();

    props.resumable.resumable.on("fileProgress", function(file) {
        progress.value = file.progress() * 100;
        contents.value.map(content => {
            if(clickedId.value !== content.id) return;
            content.thumbnail = "";
            content.duration = 0;
            content.progress = progress.value
        });
    });

    props.resumable.resumable.on("fileSuccess", function(file, response) {
        response = JSON.parse(response);
        if(!isAddingContent.value) {
            contents.value.map(content => {
                if(clickedId.value !== content.id) return;
                content.thumbnail = response.thumbnail;
                content.duration = response.duration;
                content.title = response.title;
                content.progress = 0
            });
        } else {
            contents.value.push({...response});
            progress.value = 0
            uploadingTitle.value = "";
            is_uploading.value = false;
            hasFile.value = false;
        }
    })

}
function uploadPreparation() {
    setTimeout(() => {
        const content = document.getElementById("content-video");
        props.resumable.resumable.assignBrowse(content);
    }, 0)
}

let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function addContent(id, action = 1) {
    let modal = new Modal();
    actionType.value = action;
    clickedId.value = id;
    modal.oneInput("Upload Content", successUpload, true, true, "html", uploadPreparation,
    '<input type="text" id="content-title" class="mb-2" style="width: 100%; border: 1px solid var(--primary); resize: none" ><textarea id="content-description" type="text" style="width: 100%; border: 1px solid var(--primary); height: 100px; resize: none" class="mb-2"></textarea> <input id="content-video" style="border: none;width: 100%;" type="file" value="Choose Files"/>', csrf)
}


props.resumable.resumable.on("fileAdded", function(file) {
    hasFile.value = true;
})
</script>

<style>

</style>
