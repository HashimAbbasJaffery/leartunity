<template>
<label for="profile_pic">
    <img :src="`/profile/${ profile_pic }`" ref="profile_image"/>
    <div class="edit-cover flex" style="top: 0px; width: 25px; height: 25px;">
        <i class="fa-solid fa-pencil"></i>
    </div>
    <input id="profile_pic" type="file" @change="changePicture($event, 'profile')" name="profile_pic" class="none picture" />
</label>
</template>

<script setup>
import Cropper from "../../../../resources/js/Classes/Cropper.js";
import {ref} from "vue"

let props = defineProps({
    profile_pic: String,
    id: Number
})
let profile_pic = ref(props.profile_pic);
let emit = defineEmits(["toggleModal"]);

let profile_image = ref();
let cropper = new Cropper(134, 134, "circle", "#cropper");

const changePicture = (element, type) => {
    emit("toggleModal");
    const crp = document.getElementById("cropper");
    let $image_crop;
    $image_crop = cropper.get();
    if(type === 'cover') {
        cropper.destroy();
        cropper = new Cropper(856, 300, "square", "#cropper");
        $image_crop = cropper.get();
    }
    cropper.bindPicture(element.target);
}
$('#modal-gateway').click(function(event){
cropper.upload(function(resp) {
    const name = "profile_pic";
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
            profile_pic.value = fileName;

            const element = document.querySelector(`.${fileType === 'profile_pic' ? 'profile_pic' : 'cover'}`);
            const url = `url('${ (fileType === "profile_pic") ? '/profile/' : '/cover/' }${fileName}')`;
            element.style.backgroundImage = url;
            cropper.destroy();
            $("#modal-gateway").off("click");
        })
})
})
</script>

<style>

</style>
