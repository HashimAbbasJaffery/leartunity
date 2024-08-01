<script setup>
import Layout from "../../Shared/Layout.vue";
import Course from "../../Components/Course.vue";
import {defineProps, reactive, ref, provide} from "vue"
import Filter from "../../Components/Category/Filter.vue"
import Buttons from "../../Components/Essentials/Buttons.vue";
import Category from "../../Components/Category/Category.vue";
import axios from "axios";
import Loading from "../../Components/Essentials/Loading.vue";

import {router} from "@inertiajs/vue3"


let props = defineProps({
    categories: Array,
    courses: Array
})

let courses = ref(props.courses);
let loading = ref(false)


let clear = ref(false);
provide("clear", clear);

let filters = reactive({
    categoryList: [],
    from: null,
    to: null,
    type: "Title",
    search: ""
})

async function submit() {
    loading.value = true;
    try {
        let data = await axios.post("get/courses", filters);
        courses.value = data.data
    } catch(e) {
        console.log(e)
    }
    loading.value = false
}


function clearFilter() {
    clear.value = true;
    filters.categoryList = [];
    filters.from = ""
    filters.to = "";
    filters.type = "Title"
    filters.search = ""

    setTimeout(() => {
        clear.value = false
    }, 0)
}


</script>
<template>

<Layout>
    <main>
            <section class="store container mx-auto">
                <aside class="filter-bar">
                    <form @submit.prevent="submit" id="submitFilter" style="display: block;">
                        <Filter :title="'Categories'" class="category-filter filter">
                            <ul class="mt-4">
                                <Category v-model="filters.categoryList" v-for="category in categories" :key="category.id" :category="category" />
                            </ul>
                        </Filter>
                        <Filter class="price-range filter mt-3" title="Price Range">
                            <div class="range-inputs mt-4">
                                <label>
                                    From ($)
                                    <br />
                                    <input type="number" v-model="filters.from" class="price_range" style="border-radius: 5px; width: 95%; padding-left: 10px;"/>
                                </label>
                                <label>
                                    To ($)
                                    <br />
                                    <input type="number" v-model="filters.to" class="price_range" style="border-radius: 5px; width: 95%; padding-left: 10px;"/>
                                </label>
                            </div>
                        </Filter>
                        <Filter title="Search" class="search-filter filter mt-3">
                            <div class="search-bar mt-4 flex">
                                <select id="type" v-model="filters.type" class="search-type highlighted p-1 " style="height: 35px; outline: none; width: 30%; font-size: 14px;">
                                    <option>Title</option>
                                    <option>Description</option>
                                </select>
                                <input id="q" type="text" v-model="filters.search" style="border-radius: 0px; outline: none; padding-left: 10px; width: 70%;"/>
                            </div>
                        </Filter>

                        <Buttons class="disabled:bg-black/60" :disabled="loading" :value="loading ? 'Fetching...' : 'Search'" v-model="filters.search" />
                    </form>
                    <Buttons value="Clear Filters" @click="clearFilter" lighted/>
                </aside>
                <div class="store-section relative mb-40">
                    <Loading :active="loading">
                        <p class="mt-3">Fetching...</p>
                    </Loading>
                    <div class="grid grid-cols-3 gap-4 store-cards" v-if="courses.length">
                        <Course v-for="course in courses" :key="course.id" :course="course" class="course" />
                    </div>
                    <div v-if="!courses.length" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">No Course found by matching with your filter</span>
                    </div>
                    <div class="load-more_section">
                        <Buttons value="Load More" class="highlighted load-more" />
                    </div>
                </div>
            </section>
    </main>
</Layout>

</template>

