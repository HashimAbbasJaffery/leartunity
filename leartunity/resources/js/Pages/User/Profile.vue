<template>
<Layout>

<!-- Modal toggle -->
    <p>{{ isOpen }}</p>
    <Modal @changeProfile="profilePic = $event" @changeCover="cover = $event" @toggleModal="isOpen = $event" :id="profile.id" :cropperObj="cropper"></Modal>
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

                <section class="level mt-3">
                    <p>Watching: <span class="views" ref="views">{{ watching }}</span></p>
                </section>

                <h1 style="font-weight: 600;" class="mb-1 mt-3">Streak</h1>
                <section style="border: 3px solid grey; width: 27px; height: 27px; font-size: 13px;"  class="rounded-full text-black flex items-center justify-center">
                    0
                </section>
            </div>
            <p v-else class="bg-red-500 text-white px-3 py-2 rounded mr-5 text-xs">You must login to access full features</p>
        </aside>

        <section id="other-info" style="width: 100%;">
            <div class="courses grid grid-cols-3 gap-4">
                <Course v-for="course in courses.data" :key="course.id" :course="course"></Course>
            </div>
            <div v-if="!courses.data.length" class="text-white p-2 rounded mb-3" style="width: 100%; background: var(--primary)">No Courses found</div>

                <div class="load-more_section">
                    <button class="highlighted load-more" style="">Load More</button>
                </div>
        </section>
    </div>
</Layout>
</template>

<script setup>

import UserInfo from '../../Components/Essentials/UserInfo.vue';
import Layout from '../../Shared/Layout.vue';
import Course from "../../Components/Course.vue"
import Followers from '../../Components/Essentials/Followers.vue';
import { usePage } from '@inertiajs/vue3';
import {ref, provide} from "vue"
import Modal from '../../Components/Modal.vue';

let props = defineProps({
    courses: Array,
    profile: Object
})



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
Echo.join(`profile.${props.profile.id}`)
    .here((users) => {
        console.log(users)
        const length = users.length;
        viewers = length;
        watching.value = length;
    })
    .joining((users) => {
        viewers++;

        watching.value = viewers;
    })
    .leaving((users) => {
        viewers--;
        watching.value = viewers;
    })
    .error((error) => {
        console.log(error);
    })


let isOpen = ref(false);
provide("isOpen", isOpen);
provide("cropper", cropper)
let cover = ref(props.profile.cover);
let profilePic = ref(props.profile.profile_pic);

</script>

<style>

</style>
