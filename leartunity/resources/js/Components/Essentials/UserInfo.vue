<template>

<div class="profile-intro container mx-auto cover" :style="`background: url('/cover/${cover}') no-repeat; background-size: cover;`">
    <div class="profile-pic profile_pic" style="background: url('#');  background-size: cover;">
        <ProfilePic @changePicture="changePicture($event)" :profile_pic="profile_pic" :id @toggleModal="isOpen = true"></ProfilePic>
    </div>
    <label for="cover">
        <div class="edit-cover flex">
            <i class="fa-solid fa-pencil"></i>
        </div>
        <input id="cover" @change="changePicture($event, 'cover')" type="file" name="cover" class="none picture" />
    </label>
</div>
</template>

<script setup>
import ProfilePic from './ProfilePic.vue';
import Cropper from "../../../../resources/js/Classes/Cropper.js";
import {ref, toRef, onMounted} from "vue"
import { router } from '@inertiajs/vue3';

let props = defineProps({
    cover: String,
    profile_pic: String,
    id: Number
});
toRef(props.profile_pic)
toRef(props.cover)



let emit = defineEmits(["toggleModal", "sendCropper"]);


let cropper = new Cropper(134, 134, "circle", "#cropper");
const changePicture = (element, type) => {
    emit("toggleModal", true);
    let $image_crop;
    if(type === 'cover') {
        cropper.destroy();
        cropper = new Cropper(856, 300, "square", "#cropper");
        $image_crop = cropper.get();
    } else {
        cropper.destroy();
        cropper = new Cropper(134, 134, "circle", "#cropper");
        $image_crop = cropper.get();
    }
    cropper.bindPicture(element.target);
    emit("sendCropper", cropper);
}

</script>

<style>

</style>
