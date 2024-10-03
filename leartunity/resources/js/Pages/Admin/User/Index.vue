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
    </div>
    <Loading :active="loading" style="height: 500px">
        <p class="mt-3" v-translate>Fetching...</p>
    </Loading>
    <Table :titles="['User', 'Role', 'Followers', 'Streak', 'Since', 'Action']" :data="users">
        <tr v-for="user in users.data" :key="user.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <User :user="user"></User>
        </tr>
        <template #pagination>
            <ul class="flex">
                <li @click="pagination(link.url)" v-for="link in links" :key="link.label" :style="{ opacity: (link.active || !link.url) ? 0.5 : 1 }" class="ml-2 text-white px-4 rounded cursor-pointer" style="background: var(--primary);" v-html="link.label"></li>
            </ul>
        </template>
    </Table>
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
import User from '../../../Components/User.vue';
import { debounce } from 'chart.js/helpers';
import Loading from '../../../Components/Essentials/Loading.vue';

let props = defineProps({
    users: Object
})

let users = ref(props.users);
let keyword = ref();
let loading = ref(false);
let links = ref(props.users.links);



const pagination = async url => {
    loading.value = true;
    window.scroll({
        top: 0,
        behavior: 'smooth' // Optional: for a smooth scrolling effect
    });
    loading.value = true;
    let pageUsers = await axios.get(`${url}`);
    links.value = pageUsers.data.links;
    pageUsers = pageUsers.data;
    users.value = pageUsers;
    loading.value = false;
    loading.value = false;

}

watch(keyword, debounce(async () => {
    loading.value = true;
    const pageUsers = await axios.get(`/admin/users?keyword=${keyword.value}`);
    users.value = pageUsers.data;
    links.value = pageUsers.data.links;
    loading.value = false;
}, 1000))

</script>
