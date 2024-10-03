<template>
<Layout>
    <main>
        <AdminNavbar></AdminNavbar>
        <section class="container mx-auto">
            <p>Main Color</p>
            <div class="choose-color flex items-center">
                <form class="inline flex items-center" method="POST" @submit="add">
                    <input type="color" v-model="color" id="color-picker" name="hexColor" style="border: none; width: 90%;" value="">
                    <input type="submit" value="Add To Swatch" style="cursor: pointer;border-radius: 0px; width: 10%; font-size: 13px; height: 25px;">
                </form>
            </div>
            <div class="swatches flex mt-3 flex-wrap" style="width: 40%;">
                <label v-for="swatch in swatches" :key="swatch.id">
                    <div @click="color = swatch.hexColor" class="color mb-4 mr-2" :style="{ 'background': swatch.hexColor }" style="cursor: pointer; width: 20px; height: 20px;">&nbsp;</div>
                    <input type="radio" name="" class="none">
                </label>
            </div>
            <input type="submit" @click="changeColor" class="block mb-4 change-color" value="Change Color" style="cursor: pointer;border-radius: 0px; width: 20%; font-size: 13px; height: 25px;">
        </section>
        <section class="choose-fonts container mx-auto">
            <h1>Search Google Fonts</h1>
            <input type="text" class="rounded mb-4" name="search-fonts" id="search-fonts" style="border-radius: 0px; height: 25px;">
            <div class="none searched-result">
                <h1>Font</h1>
                <div class="font block px-2 py-3 mb-3 rounded flex items-center justify-between" style="font-size: 20px; border: 1px solid black; width: 100%;">
                    <p class="preview-phrase">The quick brown fox jumps over the lazy dog.</p>
                    <label for="font-1" class="flex">
                        <input type="radio" id="font-1" name="" class="none">
                        <button style="font-size: 13px;" data-link="" data-name="" class="choose bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">Click to Choose</button>
                    </label>
                </div>
            </div>
        </section>
    </main>
</Layout>
</template>
<script setup>
import Layout from "../../../Shared/Layout.vue";
import AdminNavbar from "../../../Components/AdminNavbar.vue";
import {ref, watch} from "vue";
import axios from "axios";
import Modal from "../../../Classes/Modal";

const modal = new Modal();
console.log(process);

let props = defineProps({
    setting: Object,
    swatches: Object
})

let swatches = ref(props.swatches);
let color = ref(props.setting.primary_color);

watch(color, function() {
    document.documentElement.style.setProperty('--primary', color.value);
})

const add = async e => {
    e.preventDefault();
    const status = await axios.post("/admin/swatch/add", { hexColor: `${color.value}` });
    swatches.value.push(status.data);
    modal.success("Color has been added in swatch!");
}

const changeColor = e => {
    e.preventDefault();
    modal.success("Color of website has been changed!");
    const status = axios.put(`/admin/color/update`, {primary_color: color.value});
}


</script>
