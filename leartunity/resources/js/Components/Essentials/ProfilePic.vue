<template>
<label for="profile_pic">
    <img :src="`/profile/${ profile_pic }`" ref="profile_image"/>
    <div class="edit-cover flex" style="top: 0px; width: 25px; height: 25px;">
        <i class="fa-solid fa-pencil"></i>
    </div>
    <input id="profile_pic" type="file" @change="emit('changePicture', $event)" name="profile_pic" class="none picture" />
</label>
</template>

<script setup>
import {ref, toRef} from "vue"

import Cropper from "../../../../resources/js/Classes/Cropper.js";

let props = defineProps({
    profile_pic: String,
    id: Number
})
toRef(props.profile_pic)
let emit = defineEmits(["toggleModal", "changePicture"]);

let profile_image = ref();


</script>

<style>

</style>
