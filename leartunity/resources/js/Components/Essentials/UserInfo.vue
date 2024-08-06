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
import {ref, toRef} from "vue"
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
// $('#modal-gateway').click(function(event){
//     console.log("should be uploading...")
// cropper.upload(function(resp) {
//     console.log("uplading...")
//     const type = cropper.getType();
//     const name = type === "square" ? "cover" : "profile_pic";
//     const data = new FormData();
//     data.append(name, resp);
//     let parameters = {
//         [name]: resp
//     }
//     axios.post(`/user/${ props.id }/picture`, data)
//         .then(res => {

//             const data = res.data;
//             console.log(data);
//             $(".cancel").click();

//             const isSuccess = data.type;
//             if(isSuccess === "failed") return;
//             console.log(data);
//             const fileType = data.message[0];
//             const fileName = data.message[1];

//             if(type === "square") {
//                 cover.value = fileName
//             } else {
//                 picture.value = fileName;
//             }

//             $("#modal-gateway").off("click");
//             emit("toggleModal", false);
//         })
// })
// })

function testing() {
    console.log("CLiked")
}
</script>

<style>

</style>
