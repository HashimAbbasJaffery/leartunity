<template>
    <Teleport to="body">
        <VideoUploadModal @fileAdded="uploadPreparation($event)" :active="isOpenedModal" style="width: 100%;"></VideoUploadModal>
    </Teleport>
  <div>
        <button class="accordion rounded my-2" :class="{'is-open': expand}" @click="sectionExpand" style="border: 1px solid black;">{{ section.section_name }}</button>
        <div v-if="expand">
        <button type="button" v-if="contents?.length ?? false" @click="deleteMultiple" :disabled="!selected_contents.length || isDeletingMultiple" class="disabled:bg-red-300 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
            {{  isDeletingMultiple ? "Deleting..." : "Delete Selected Content"  }}
        </button>
            <ul class="ml-5 flex w-full items-center" v-for="content in contents" :key="content.id">
                <input type="checkbox" v-model="selected_contents" :value="content.id" class="inline-block" name="" id="">
                <div class="content w-full">
                    <Content @update="addContent($event, 2)" @deleted="contents = $event" :content="content" :instructor="instructor"></Content>
                </div>
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

import {ref, computed} from "vue"
import Modal from "../Classes/Modal";
import Content from "./Content.vue";
import axios from "axios";
import VideoUploadModal from "./VideoUploadModal.vue";

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

let resumable = ref(props.resumable);
let contents = ref(props.section.contents)
let progress = ref(0);
let uploadingTitle = ref("");
let is_uploading = ref(false);
let expand = ref(false);
let hasFile = ref(false);
let actionType = ref(1);
let clickedId = ref();
let isOpenedModal = ref(false);
let selected_contents = ref([]);
let isDeletingMultiple = ref(false);

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

const getUploadURL = () => `/instructor/content/${clickedId.value}/${isAddingContent.value == 1 ? 'add' : 'update'}`;

const showProgress = title => {
    if(isAddingContent.value) {
        uploadingTitle.value = title;
        is_uploading.value = true;
    }
}

const initiateResumable = (title, description) => {
    resumable.value.resumable.opts.query = {
        ...resumable.value.resumable.opts.query,
        title,
        description
    }
    resumable.value.resumable.opts.target = getUploadURL();
}

const ShowFileUploadProgress = () => {
    resumable.value.resumable.on("fileProgress", function(file) {
        progress.value = file.progress() * 100;
        contents.value.map(content => {
            if(clickedId.value !== content.id) return;
            content.thumbnail = "";
            content.duration = 0;
            content.progress = progress.value
        });
    });
}

const uploadOnSuccess = () => {
    resumable.value.resumable.on("fileSuccess", function(file, response) {
        response = JSON.parse(response);
        if(!isAddingContent.value) {
            contents.value.map(content => {
                if(clickedId.value !== content.id) return;
                content.thumbnail = response.thumbnail;
                content.duration = response.duration;
                content.title = response.title;
                content.progress = 0
            });
            hasFile.value = false;
        } else {
            const isAppended = contents.value.filter(content => content.id === response.id).length;
            !isAppended && contents.value.push({...response});
            progress.value = 0;
            uploadingTitle.value = "";
            is_uploading.value = false;
            hasFile.value = false;
        }
    })
}

const successUpload = () => {
    const content = document.getElementById("content-video");
    const title = document.getElementById("content-title").value;
    const description = document.getElementById("content-description").value;
    let isEveryFieldFilled = title && description;
    if(!isEveryFieldFilled) return;
    const url = getUploadURL();

    // If no video file is attached
    if(!hasFile.value) {
        withoutFileUpload(url, title, description);
        return;
    }

    showProgress(title);
    initiateResumable(title, description);

    resumable.value.resumable.upload();

    ShowFileUploadProgress();

    uploadOnSuccess();

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


resumable.value?.resumable?.on("fileAdded", function(file) {
    hasFile.value = true;
})

const deleteMultiple = async () => {
    const modal = new Modal();
    modal.oneInput("Are you sure you want to delete selected contents? It is not reversible!", async function() {
        isDeletingMultiple.value = true;
        const status = await axios.post(`/api/content/${props.section.id}/delete`, { _method: 'delete', contents: selected_contents.value });
        modal.success("Successfully deleted selected contents!");
        contents.value = status.data;
        selected_contents.value = [];
        isDeletingMultiple.value = false;
    }, true, "Delete!", "");
}
</script>

<style>

</style>
