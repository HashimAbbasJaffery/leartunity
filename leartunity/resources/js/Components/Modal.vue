<template>
    <!-- <div id="cropper"></div> -->
    <div v-show="isOpen" class="modal-container bg-black/60 w-full h-full fixed z-50 top-0 flex justify-center items-center">
        <div class="bg-white w-5/6 rounded p-4">
            <h1 class="font-bold text-xl mb-4">Crop Image</h1>
            <div id="cropper"></div>
            <div class="actions">
                <button @click="upload" class="bg-blue-400 text-white px-4 py-1 rounded mt-3 hover:bg-blue-500">Crop</button>
                <button class="ml-3 bg-red-400 text-white px-4 py-1 rounded mt-3 hover:bg-red-500" @click="isOpen = false">Cancel</button>
            </div>
        </div>
    </div>

</template>

<script setup>

import {inject, watch, ref} from "vue"
import ImageModal from "../Components/ImageModal.vue";

let isOpen = inject("isOpen");
let toggle = ref();


let props = defineProps({
    cropperObj: Object,
    id: Number
})

let emit = defineEmits(["toggleModal", "changeProfile", "changeCover"]);

function upload() {
    props.cropperObj.upload(resp => {
    console.log("uplading...")
    const type = props.cropperObj.getType();
    const name = type === "square" ? "cover" : "profile_pic";
    const data = new FormData();
    data.append(name, resp);
    axios.post(`/user/${ props.id }/picture`, data)
        .then(res => {

            const data = res.data;
            console.log(data);
            $(".cancel").click();

            const isSuccess = data.type;
            if(isSuccess === "failed") return;
            const fileName = data.message[1];

            if(type === "square") {
                emit("changeCover", fileName)
            } else {
                emit("changeProfile", fileName)
            }

            $("#modal-gateway").off("click");
            emit("toggleModal", false);
        })
})
}

</script>

<style>

</style>
