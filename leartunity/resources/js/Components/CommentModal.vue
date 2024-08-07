<template>
    <div v-if="active" class="modal-container bg-black/60 w-full h-full fixed z-50 top-0 flex justify-center items-center">
        <div class="bg-white w-1/2 rounded p-4">
            <h1 class="font-bold text-xl mb-4">Post a Comment</h1>
            <textarea id="comment" v-model="comment" class="w-full rounded resize-none p-2 outline-none" style="height: 200px;" placeholder="Write Comment">{{ `@${replying_name} ` }}</textarea>
            <div class="actions">
                <button @click="submit" class="bg-blue-400 text-white px-4 py-1 rounded mt-3 hover:bg-blue-500">Post</button>
                <button @click="emit('hide')" class="ml-3 bg-red-400 text-white px-4 py-1 rounded mt-3 hover:bg-red-500">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {toRef, ref, inject} from "vue";
import { router } from "@inertiajs/vue3";
import NavLink from "../Components/NavLink.vue"
import axios from "axios";


let props = defineProps({
    active: Boolean,
    replying_to: Number,
    replying_name: String
})
toRef("replying_to");
toRef("replying_name");

let comment = ref();

let course = inject("course");
let content = inject("current_content");

let emit = defineEmits(["hide", "addCourse"]);
let submit = async () => {
    const status = await axios.post(`/learn/comment/${course.slug}/${content.id}/add`, { comment: comment.value, replying_to: props.replying_to });
    emit("addCourse", status.data);
}



</script>

<style>

</style>
