<template>
<Layout>

<!-- Modal toggle -->

    <Teleport to="body">
        <Modal @changeProfile="profilePic = $event" @changeCover="cover = $event" @toggleModal="isOpen = $event" :id="profile.id" :cropperObj="cropper"></Modal>
    </Teleport>
    <UserInfo @sendCropper="cropper = $event" @toggleModal="isOpen = $event" :profile_pic="profilePic" :cover="cover" :id="profile.id"></UserInfo>
    <div class="profile-content container mx-auto flex">

        <aside  class="py-4 h-auto" style="width: 30%;">

            <div v-if="user" class="aside-wrapper">
                <p style="font-size: 20px; font-weight: 600; margin-bottom: 10px;">{{ profile.user.name }}</p>
                <Followers v-if="user" :isFollowed="follows.includes(user_id)" :followers="profile.user.follows.length" :id="profile.id"></Followers>
                <h1 style="font-weight: 600;" class="mb-1">Achievements</h1>
                <section class="achievements flex">
                        <img :src="`/badges/starting.png`" class="mr-2" style="border-radius: 50px;" height="50" width="50"/>
                        <!-- <p style="font-size: 14px;">No badges have been awarded yet!</p> -->
                </section>

                <h1 style="font-weight: 600;" class="mb-1 mt-3">Streak</h1>
                <section style="border: 3px solid grey; width: 27px; height: 27px; font-size: 13px;"  class="rounded-full text-black flex items-center justify-center">
                    0
                </section>
            </div>
            <p v-else class="bg-red-500 text-white px-3 py-2 rounded mr-5 text-xs">You must login to access full features</p>
        </aside>

        <main style="width: 100%;">


            <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                <li class="me-2" @click="openTab = 'courses'">
                    <a href="#" :class="{ 'text-blue-600': openTab === 'courses' }" aria-current="page" class="inline-block p-4  bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500">Courses</a>
                </li>
                <li class="me-2" @click="openTab = 'certificates'">
                    <a href="#" :class="{ 'text-blue-600': openTab === 'certificates' }" class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Certificates</a>
                </li>
            </ul>

            <section id="other-info" style="width: 100%;" v-if="openTab === 'certificates'">
                <div class="flex flex-start flex-wrap gap-2 justify-center certificates mb-3">

                    <div v-for="certificate in certificates" :key="certificate.id" class="certificate text-center" style="width: 300px;">
                        <iframe :src="`/${certificate.certificate}/certificate.pdf`"></iframe>
                        <p class="text-xs text-center mt-3">{{ certificate.course.title }}</p>
                    </div>
                    <div v-if="!certificates.length" class="text-white p-2 rounded mb-3" style="width: 100%; background: var(--primary)">No Certificates found</div>


                </div>
            </section>
            <section id="other-info" style="width: 100%;" v-if="openTab === 'courses'">
                <div>

                    <Loading v-if="loading" :active="true" style="width: auto; height: auto; margin: auto; top: 50%; left: 50%;  ">
                        <p class="mt-3" v-translate>Fetching...</p>
                    </Loading>
                    </div>
                    <div v-if="!loading" id="coursesCollection" class="courses grid grid-cols-3 gap-4">
                        <Course v-for="course in courses.data" :key="course.id" :course="course"></Course>
                    </div>
                    <div class="pagination-pages mb-4" v-if="courses.data.length">
                        <ul class="flex">
                            <li @click="pagination(link.url)" v-for="link in links" :key="link.label" :style="{ opacity: (link.active || !link.url) ? 0.5 : 1 }" class="ml-2 text-white px-4 rounded cursor-pointer" style="background: var(--primary);" v-html="link.label"></li>
                        </ul>
                    </div>
                    <div v-if="!courses.data.length" class="text-white p-2 rounded mb-3" style="width: 100%; background: var(--primary)">No Courses found</div>

            </section>
        </main>

    </div>
</Layout>
</template>

<script setup>

import UserInfo from '../../Components/Essentials/UserInfo.vue';
import Layout from '../../Shared/Layout.vue';
import Course from "../../Components/Course.vue"
import Followers from '../../Components/Essentials/Followers.vue';
import { usePage } from '@inertiajs/vue3';
import {ref, provide, onMounted, onUnmounted} from "vue"
import Modal from '../../Components/Modal.vue';
import axios from 'axios';
import Loading from "../../Components/Essentials/Loading.vue";
import { Teleport } from 'vue';


let props = defineProps({
    courses: Array,
    profile: Object,
    certificates: Object
})


let courses = ref(props.courses);
let links = ref(courses.value.links);
let loading = ref(false);
let openTab = ref('courses');


let page = usePage();

let user = page.props.auth.user;
let cropper = ref();

let user_id = null;
let follows = [];
if(user) {
    user_id = page.props.auth.user.id;
    follows = page.props.auth.user.follows;
    follows = follows.map(follow => follow.id);
}
let watching = ref(0);

let viewers = 0;

let isOpen = ref(false);
provide("isOpen", isOpen);
provide("cropper", cropper)
let cover = ref(props.profile.cover);
let profilePic = ref(props.profile.profile_pic);

let pagination = async url => {
    coursesCollection.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });

    const coursesData = await axios.get(url);
    courses.value = coursesData.data;
    links.value = coursesData.data.links;
    loading.value = false;
}



</script>

<style>

</style>
