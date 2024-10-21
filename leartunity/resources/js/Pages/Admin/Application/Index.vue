<template>
    <Layout>
        <main>
            <AdminNavbar></AdminNavbar>
            <section id="users" class="container mx-auto">
                <div v-if="applications.data?.length" class="relative overflow-x-auto shadow-md sm:rounded-lg" style="height: 1170px">
                    <Loading :active="loading" style="height: 500px">
                        <p class="mt-3" v-translate>Fetching...</p>
                    </Loading>
                    <Table :titles="['User', 'Fullname', 'Qualification', 'Action']">
                        <tr v-for="application in applications.data" :key="application.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <ApplicationRow :application="application"></ApplicationRow>
                        </tr>
                    </Table>

                <ul class="flex">
                    <li @click="pagination(link.url)" v-for="link in links" :key="link.label" :style="{ opacity: (link.active || !link.url) ? 0.5 : 1 }" class="ml-2 text-white px-4 rounded cursor-pointer" style="background: var(--primary);" v-html="link.label"></li>
                </ul>
                </div>
                <div v-else class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    No Applications found!
                </div>
            </section>
        </main>
    </Layout>
</template>
<script setup>

import Table from '../../../Components/Table.vue';
import Layout from '../../../Shared/Layout.vue';
import AdminNavbar from "../../../Components/AdminNavbar.vue";
import {ref} from "vue";
import Loading from '../../../Components/Essentials/Loading.vue';
import ApplicationRow from './ApplicationRow.vue';
import axios from 'axios';
import NavLink from '../../../Components/NavLink.vue';

let props = defineProps({
    applications: Object
})

let applications = ref(props.applications);
let keyword = ref();
let loading = ref(false);
let links = ref(props.applications.links);
let current_page = ref(props.applications.current_page);

const pagination = async url => {
    loading.value = true;
    window.scroll({
        top: 0,
        behavior: 'smooth' // Optional: for a smooth scrolling effect
    });
    loading.value = true;
    let pageApplications = await axios.get(`${url}`);
    current_page.value = pageApplications.data.current_page;
    links.value = pageApplications.data.links;
    pageApplications = pageApplications.data;
    applications.value = pageApplications;
    loading.value = false;
    loading.value = false;
}

</script>
