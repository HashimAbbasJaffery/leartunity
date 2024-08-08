<template>
  <div class="comment p-4" :class="{ 'reply': comment.replies_to }" style="border-radius: 10px;">
    <div class="comment-content w-full flex">
        <div class="comment-author w-1/5 flex flex-col text-center">
            <p v-if="isInstructor" class="text-2xs mb-2 capitalize bg-blue-400 w-1/3 mx-auto rounded">Instructor</p>
            <img class="mx-auto" :class="{'border-4 border-blue-500 rounded-full bg-blue-400': isInstructor}" :src="`/profile/${comment.user.profile.profile_pic}`" height="90" width="90"/>
            <p class="text-center text-xs mt-2">Posted {{ moment(comment.created_at).fromNow() }}</p>
        </div>
        <div class="comment-main w-4/5">
            <h1 class="text-xl font-bold capitalize pb-3">{{ comment.user.name }}</h1>
            <p class="text-sm pb-3">
                {{ comment.comment }}
            </p>
            <button @click="emit('toggleModal', [comment.id, comment.user.name])" class="text-xs bg-blue-400 px-4 py-1 rounded hover:bg-blue-500">Reply</button>
        </div>
    </div>
</div>
</template>

<script setup>
import moment from 'moment';
import {computed} from "vue"
import { usePage } from '@inertiajs/vue3';


let props = defineProps({
    comment: Object
})

let emit = defineEmits(["toggleModal"])
console.log(props.comment);

let page = usePage();
const user = page.props.auth.user;

let isInstructor = computed(() => user && user.id === props.comment.user_id)




</script>

<style>

</style>
