<template>
<button data-modal-target="default-modal" ref="toggle" data-modal-toggle="default-modal" class="open-modal hidden block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
  Toggle modal
</button>

<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center max-w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Crop Image
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only" id="lol">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div id="cropper">&nbsp;</div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button @click="testing" type="button" id="modal-gateway" class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crop</button>
                <button @click="isOpen = false" data-modal-hide="default-modal" type="button" class="cancel py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import {inject, watch, ref} from "vue"
let isOpen = inject("isOpen");
let toggle = ref();

let props = defineProps({
    cropperObj: Object,
    id: Number
})

watch(isOpen, () => {
    console.log(isOpen.value);
    if(isOpen.value) {
        console.log("Open");
        toggle.value.click();
    } else {
        console.log("Close")
        toggle.value.classList.add = "hide"
    }
})

let emit = defineEmits(["toggleModal", "changeProfile", "changeCover"]);

function testing() {
    props.cropperObj.upload(resp => {
    console.log("uplading...")
    const type = props.cropperObj.getType();
    const name = type === "square" ? "cover" : "profile_pic";
    const data = new FormData();
    data.append(name, resp);
    let parameters = {
        [name]: resp
    }
    axios.post(`/user/${ props.id }/picture`, data)
        .then(res => {

            const data = res.data;
            console.log(data);
            $(".cancel").click();

            const isSuccess = data.type;
            if(isSuccess === "failed") return;
            console.log(data);
            const fileType = data.message[0];
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
