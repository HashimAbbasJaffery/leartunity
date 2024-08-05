<template>

<Modal></Modal>
<div class="profile-intro container mx-auto cover" :style="`background: url('/cover/${cover}') no-repeat; background-size: cover;`">
    <div class="profile-pic profile_pic" style="background: url('#');  background-size: cover;">
        <ProfilePic :profile_pic :id @toggleModal="isOpen = true"></ProfilePic>
    </div>
    <label for="cover">
        <div class="edit-cover flex">
            <i class="fa-solid fa-pencil"></i>
        </div>
        <input id="cover" type="file" name="cover" onchange="changePicture(this, 'cover')" class="none picture" />
    </label>
</div>
</template>

<script setup>
import ProfilePic from './ProfilePic.vue';
import {provide, ref} from "vue"
import Modal from '../Modal.vue';

let props = defineProps({
    cover: String,
    profile_pic: String,
    id: Number
})


let isOpen = ref(false);
provide("isOpen", isOpen)


</script>

<style>

</style>
