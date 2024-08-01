<template>
    <form @submit.prevent="submit" enctype="multipart/form-data" id="update-course" style="width: 100%; display: block;" class="py-2" method="POST" action="#">
            <label for="title" style="display: block; margin-bottom: 20px">
                Course Title
                <p class="text-red-600" v-if="!form.title" style="font-size: 13px;">{{ $page.props.errors?.title ?? "Title field is required" }}</p>
                <input type="text" v-model="form.title" class="rounded px-2 @error('title') has-error @enderror" id="title" name="title" style="width: 100%;"/>
            </label>
            <label for="description" style="display: block; margin-bottom: 20px">

                <p class="text-red-600" v-if="!form.description" style="font-size: 13px;">{{ $page.props.errors?.description ?? "Description field is required" }}</p>
                <p class="text-gray-500 text-sm">
                    <span v-if="25 - form.description.length > 0">{{ 25 - form.description.length + ' Words required' }}</span>
                    <span v-if="25 - form.description.length <= 0" class="text-green-600">Done!</span>
                </p>
                <textarea id="description" name="description" class="@error('description') has-error @enderror rounded px-2" style="height: 300px;outline: none;resize: none;width: 100%; border: 1px solid var(--primary)" v-model="form.description"></textarea>
            </label>
            <label for="pre_req" style="display: block; margin-bottom: 20px">
                Course Pre Requisites - It supports Github markdown
                <p class="text-red-600" v-if="!form.pre_req" style="font-size: 13px;">{{ $page.props.errors?.pre_req ?? "Pre Requisites Field is required" }}</p>
                <p lang="text-gray-500 text-sm">
                    <span v-if="25 - form.pre_req.length > 0">{{ 25 - form.pre_req.length + ' Words required' }}</span>
                    <span v-if="25 - form.pre_req.length <= 0" class="text-green-600">Done!</span>
                </p>
                <textarea id="description" name="pre_req" v-model="form.pre_req" class="rounded px-2" style="height: 300px;outline: none;resize: none;width: 100%; border: 1px solid var(--primary)"></textarea>
            </label>
            <div class="pre_req-preview none">&nbsp;</div>
            <label for="price" style="display: block; margin-bottom: 20px">
                Price
                <p class="text-red-600" v-if="!form.price" style="font-size: 13px;">{{ $page.props.errors?.price ?? "Price field is required" }}</p>
                <input type="number" v-model="form.price" class="rounded px-2 @error('price') has-error @enderror" id="price" name="price" style="width: 100%;"/>
            </label>
            <label for="thumbnail" style="display: block; margin-bottom: 20px">
                <span class="highlighted px-3 py-2">Upload Thumbnail</span>
                <!-- <p class="text-red-600 mt-2" style="font-size: 13px;">Error</p> -->
                <input type="file" class="none rounded px-2 @error('thumbnail') has-error @enderror" id="thumbnail" name="thumbnail" style="width: 100%;"/>
            </label>
            <div class="current-image" v-if="course">
                <p>Current Image</p>
                <img class="rounded mb-8 p-3 mt-3" width="250" style="border: 1px solid black;" :src="`/course/${course.thumbnail}`" alt="">
            </div>
            <div id="cropper"></div>


            <p class="text-red-600" v-if="!form.categories.length" style="font-size: 13px;">{{ $page.props.errors?.categories ?? "Select at least one category" }}</p>
            <div class="categories rounded mb-3 flex items-start flex-wrap" style="overflow: auto;border: 1px solid black; height: 100px;">
                <label v-for="category in categories" :key="category.id" class="flex items-center px-2" for="category-{id}">
                    <input :value="category.id" v-model="form.categories" class="mr-2 category @error('categories') has-error @enderror" type="checkbox" :id="category.id" style="width: 15px;"/>
                    {{ category.category }}
                </label>
            </div>

            <input type="text" v-show="false" name="base64" v-model="form.image" id="base64">
            <input type="hidden" name="categories" id="categories"/>
            <button type="submut" class="highlighted px-3 preview mb-1" data-for="description">Create</button>
        </form>
</template>

<script setup>
import {ref, onMounted, defineProps} from "vue"
import { router } from "@inertiajs/vue3";
import { useForm, Head } from '@inertiajs/vue3';
import Cropper from "../../../Classes/Cropper.js";

let props = defineProps({
    course: Array,
    categories: Array,
    href: "",
    method: {
        type: String,
        default: "PUT"
    }
});

let isUploaded = ref(false);
const categoriesList = props.course?.categories?.map(category => category.id) ?? [];

const form = useForm({
    title: props.course?.title ?? "",
    description: props.course?.description ?? "",
    pre_req: props.course?.pre_req ?? "",
    price: props.course?.price ?? "",
    categories: categoriesList,
    image: ""
})

let cropper;

const submit = () => {
    if(isUploaded.value) {
        cropper.upload(function(res) {
            form.image = res;
            const status = (props.method === "PUT") ? router.put(props.href, form) : router.post(props.href, form);
        })
    } else {
        const status = router.put(props.href, form);
    }

}


onMounted(() => {

    thumbnail.addEventListener("change", function() {
        isUploaded.value = true;
        cropper && cropper.destroy();
        cropper = new Cropper("480", "270", "square", "#cropper");
        cropper.bindPicture(this);
        cropper.upload(function(res) {
            console.log(res);
        })
    })
    const update = document.getElementById("update-course");
    update.addEventListener("submit", function(e) {
        e.preventDefault();

    })
})
</script>

<style>

</style>
