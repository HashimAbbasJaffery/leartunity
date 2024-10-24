<template>
    <div v-if="active" class="modal-container bg-black/60 w-full h-full fixed z-50 top-0 flex justify-center items-center">
        <div class="bg-white w-1/2 rounded p-4">
            <h1 class="font-bold text-xl mb-4">Start an annoucement!</h1>
            <input type="text" class="w-full rounded mb-2" placeholder="Subject" v-model="subject">
            <textarea v-model="announcement" id="review" class="w-full rounded resize-none p-2 outline-none" style="height: 200px;" placeholder="Write Review"></textarea>
            <div class="actions">
                <button @click="announce" :disabled="loading" type="button" class="disabled:bg-blue-300 disabled:cursor-not-allowed bg-blue-400 text-white px-4 py-1 rounded mt-3 hover:bg-blue-500">
                    <span class="flex items-center justify-between w-full">
                        <p class="mr-3">Post Announcement</p>
                        <span v-if="loading" class="loader-spinner"></span>
                    </span>
                </button>
                <button @click="$emit('cancel')" class="ml-3 bg-red-400 text-white px-4 py-1 rounded mt-3 hover:bg-red-500">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script setup>

import axios from 'axios';
import { ref } from 'vue';

let subject = ref("");
let announcement = ref("");
let loading = ref(false);

let props = defineProps({
    active: Boolean,
    id: Number
})

let emit = defineEmits(["announced"]);

const announce = async () => {
    loading.value = true;
    const status = await axios.post(route("announce", { course: props.id }), { subject: subject.value, announcement: announcement.value });
    loading.value = false;
    announcement.value = "";
    subject.value = "";
    emit("announced");
}

</script>

<style scoped>

.loader-spinner {
  width: 22px;
  height: 22px;
  display: inline-block;
  position: relative;
}
.loader-spinner::after,
.loader-spinner::before {
  content: '';
  box-sizing: border-box;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  border: 2px solid #FFF;
  position: absolute;
  left: 0;
  top: 0;
  animation: animloader-spinner 2s linear infinite;
}
.loader-spinner::after {
  animation-delay: 1s;
}

@keyframes animloader-spinner {
  0% {
    transform: scale(0);
    opacity: 1;
  }
  100% {
    transform: scale(1);
    opacity: 0;
  }
}

</style>
