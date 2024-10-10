<template>
    <Layout>
        <main>
            <AdminNavbar></AdminNavbar>
            <section id="users" class="container mx-auto">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="height: 1170px">
                    <div class="search flex justify-end mr-3">
                        <form name="q" id="q">
                            <input type="text" v-model="keyword" value="" name="keyword" id="search" style="border-radius: 0px; width: 20%; height: 25px; font-size: 14px; padding-left: 10px;" placeholder="Enter Username">
                            <input type="submit" value="Search" style="border-radius: 0px; width: 5%; font-size: 12px; height: 25px; padding: 0px;">
                        </form>
                    <NavLink @click="create" as="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Create</NavLink>
                    </div>
                    <Loading :active="loading" style="height: 500px">
                        <p class="mt-3" v-translate>Fetching...</p>
                    </Loading>
                    <Table :titles="['Category', 'Courses', 'Since', 'Status', 'Action']">
                        <tr v-for="category in categories.data" :key="category.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <Category @deleted="pagination(`/admin/categories?page=${current_page}`)" :category="category"></Category>
                        </tr>
                    </Table>

                <ul class="flex">
                    <li @click="pagination(link.url)" v-for="link in links" :key="link.label" :style="{ opacity: (link.active || !link.url) ? 0.5 : 1 }" class="ml-2 text-white px-4 rounded cursor-pointer" style="background: var(--primary);" v-html="link.label"></li>
                </ul>
                </div>
            </section>
        </main>
    </Layout>
</template>
<script setup>

import Table from '../../../Components/Table.vue';
import Layout from '../../../Shared/Layout.vue';
import AdminNavbar from "../../../Components/AdminNavbar.vue";
import {ref, watch} from "vue";
import { debounce } from 'chart.js/helpers';
import Loading from '../../../Components/Essentials/Loading.vue';
import Category from '../../../Components/Category.vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';
import NavLink from '../../../Components/NavLink.vue';
import Modal from '../../../Classes/Modal';


const page = usePage();

let props = defineProps({
    categories: Object
})

let categories = ref(props.categories);
let keyword = ref();
let loading = ref(false);
let links = ref(props.categories.links);
let current_page = ref(props.categories.current_page);

const create = () => {
    const modal = new Modal();
    modal.oneInput("Create Category", function(result) {
        const status = axios.post("/admin/category/create", { "category": result.value });
    }, true, "Create");
}


const pagination = async url => {
    loading.value = true;
    window.scroll({
        top: 0,
        behavior: 'smooth' // Optional: for a smooth scrolling effect
    });
    loading.value = true;
    let pageCategories = await axios.get(`${url}`);
    current_page.value = pageCategories.data.current_page;
    links.value = pageCategories.data.links;
    pageCategories = pageCategories.data;
    categories.value = pageCategories;
    loading.value = false;
    loading.value = false;
}

watch(keyword, debounce(async () => {
    loading.value = true;
    const pageCategories = await axios.get(`/admin/categories?keyword=${keyword.value}`);
    categories.value = pageCategories.data;
    links.value = pageCategories.data.links;
    loading.value = false;
}, 1000))

</script>
