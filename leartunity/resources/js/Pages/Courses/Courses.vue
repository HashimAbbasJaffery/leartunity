<script setup>
// import Layout from "../../Shared/Layout.vue";
import Course from "../../Components/Course.vue";
import {defineProps, reactive, computed} from "vue"
import Filter from "../../Components/Category/Filter.vue"
import Buttons from "../../Components/Essentials/Buttons.vue";
import Category from "../../Components/Category/Category.vue";
import axios from "axios";
import Loading from "../../Components/Essentials/Loading.vue";
import { usePage } from "@inertiajs/vue3";
import { provide, ref, watch } from "vue";
import { useLocaleStore } from "../../Stores/LocaleStore";
import qs from "qs";





let props = defineProps({
    categories: Array,
    courses: Array
})

let courses = ref(props.courses.data);
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

        const queryString = qs.stringify(filters, { skipNulls: true });
        let data = await axios.get(`/courses?${queryString}`);
        console.log(data);
        courses.value = data.data.data;
        links.value = data.data.links;
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

const page = usePage()




const currency = ref(page.props.auth.currency);

const localeStore = useLocaleStore();
const supportedCurrencies = page.props.supported.currencies;
localeStore.setLocaleData(supportedCurrencies);



let unit = ref(currency.value.unit ?? "$");





const links = ref(props.courses.links);


const pagination = async url => {
    window.scroll({
        top: 0,
        behavior: 'smooth' // Optional: for a smooth scrolling effect
    });
    loading.value = true;
    const queryString = qs.stringify(filters, { skipNulls: true });
    let pageCourses = await axios.get(`${url}&${queryString}`);
    links.value = pageCourses.data.links;
    pageCourses = pageCourses.data.data;
    console.log(pageCourses.links);
    courses.value = pageCourses;
    loading.value = false;

}


</script>
<template>

<Layout>
    <main>
            <section class="store container mx-auto">
                <aside class="filter-bar">
                    <form @submit.prevent="submit" id="submitFilter" style="display: block;">
                        <Filter :title="$t('Categories')" class="category-filter filter">
                            <ul class="mt-4">
                                <Category v-model="filters.categoryList" v-for="category in categories" :key="category.id" :category="category" />
                            </ul>
                        </Filter>
                        <Filter class="price-range filter mt-3" :title="$t('Price Range')">
                            <div class="range-inputs mt-4">
                                <label>
                                    <span v-translate>From</span> ({{ unit }})
                                    <br />
                                    <input type="number" v-model="filters.from" class="price_range" style="border-radius: 5px; width: 95%; padding-left: 10px;"/>
                                </label>
                                <label>
                                    <span v-translate>To</span> ({{ unit }})
                                    <br />
                                    <input type="number" v-model="filters.to" class="price_range" style="border-radius: 5px; width: 95%; padding-left: 10px;"/>
                                </label>
                            </div>
                        </Filter>
                        <Filter :title="$t('Search')" class="search-filter filter mt-3">
                            <div class="search-bar mt-4 flex">
                                <select id="type" v-model="filters.type" class="search-type highlighted p-1 " style="height: 35px; outline: none; width: 30%; font-size: 14px;">
                                    <option>Title</option>
                                    <option>Description</option>
                                </select>
                                <input id="q" type="text" v-model="filters.search" style="border-radius: 0px; outline: none; padding-left: 10px; width: 70%;"/>
                            </div>
                        </Filter>

                        <Buttons class="disabled:bg-black/60" :disabled="loading" :value="loading ? $t('Fetching...') : $t('Search')" v-model="filters.search" />
                    </form>
                    <Buttons :value="$t('Clear Filters')" @click="clearFilter" lighted/>
                </aside>
                <div class="store-section relative mb-40">
                    <Loading :active="loading">
                        <p class="mt-3" v-translate>Fetching...</p>
                    </Loading>
                    <div class="grid grid-cols-3 gap-4 store-cards" v-if="courses.length">
                        <Course @changeUnit="unit = $event" v-for="course in courses" :key="course.id" :course="course" class="course" />
                    </div>

                    <div class="pagination-pages mb-4" v-if="courses.length">
                        <ul class="flex">
                            <li @click="pagination(link.url)" v-for="link in links" :key="link.label" :style="{ opacity: (link.active || !link.url) ? 0.5 : 1 }" class="ml-2 text-white px-4 rounded cursor-pointer" style="background: var(--primary);" v-html="link.label"></li>
                        </ul>
                    </div>
                    <div v-if="!courses.length" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">No Course found by matching with your filter</span>
                    </div>
                </div>
            </section>
    </main>
</Layout>

</template>

