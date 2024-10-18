<template>


<Layout>
    <CommentModal @addCourse="comments = $event" :replying_name :replying_to @hide="active = false" :active></CommentModal>
    <div style="border: 1px solid white; background: var(--primary); width: 50%; margin: auto; height: 400px; z-index: 2;" class="animate__animated none comment-post rounded alert-box fixed left-0 right-0 bottom-0 p-2 text-white">
        <div class="comment-post-header flex items-center">
            <i class="fa-solid fa-reply mr-2"></i>
            <p>Replying to <span class="replying_to">Post</span></p>
        </div>
        <div class="comment-post-body" style="height: 75%; background: var(--primary);">
            <div class="separator">&nbsp;</div>
            <textarea type="text" id="add-comment" style="resize: none;color: white;background: var(--primary); outline: none;height: 85%;border-radius: 5px; width: 100%; margin-top: 10px;"></textarea>
            <div class="separator">&nbsp;</div>
        </div>
            <div class="comment-post-footer" style="float: right; width: 40%;">
                <button class="highlighted cancel-post" style="width: 45%;">Cancel</button>
                <button class="highlighted post-comment" style="width: 45%; background: white; color: black;">Post</button>
            </div>
    </div>
    <section class="mt-3 mb-3 px-1">
        <div class="lecture flex">
            <div class="order-2" style="width: 70%; margin-bottom: 10px;">
                    <Quiz v-if="isQuiz"></Quiz>
                    <VideoScreen :video v-else></VideoScreen>
                <div class="course-detail">
                    <div class="lecture-detail detail mt-3">
                        {{ current_content.description }}
                    </div>
                    <div class="instructor-detail detail mt-3 flex">
                        <div class="instructor-pic mr-3">
                            <img :src="`/profile/${course.author.profile.profile_pic}`" jeight="100" width="100" style="border-radius: 50px;"/>
                        </div>
                        <div class="instructor-detail" style="position: relative;">
                            <h1 style="font-weight: bold; font-size: 20px;">{{ course.author.name }}</h1>
                            <p>I am a TALL stack enthusiast. I have used Laravel to create a SaaS company, and I have 5 kids.</p>
                            <div class="links flex">
                                <a href="#">
                                    <div class="link mr-2" style="color: white;">
                                        <i class="fa-brands fa-github"></i>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="link mr-2" style="color: white">
                                        <i class="fa-brands fa-linkedin"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="additional-links flex mt-2">
                        <a href="#" class="link extra mr-2">Lesson's Code</a>
                        <a href="#" class="link extra">Download Video</a>
                    </div>
                    <div class="additional-links flex mt-2">
                        <button @click="active = true" class="link extra mr-2 comment-post-button" style="width: 100%;">Write Comment</button>
                    </div>
                    <div class="comments mt-2" v-if="comments.length">
                        <div v-for="comment in comments" :key="comment.id" >
                            <CommentVue @toggleModal="toggle($event)" :comment="comment"></CommentVue>
                            <CommentVue v-for="reply in comment.replies" :key="reply.id" @toggleModal="toggle($event)" :comment="reply"></CommentVue>
                        </div>
                    </div>
                    <div v-else class="mt-6 no-comments bg-green-400 text-white px-4 py-2 rounded border-2 border-green-500">
                        <h1>Be the first one to Comment!</h1>
                    </div>
                </div>
            </div>
            <div class="lectures order-1 mr-2" style="width: 30%">
                <div v-if="is_purchased" class="course-overview bg-gray-200 mb-4 rounded px-3 py-3">
                    <h1 class="text-center font-bold  pb-3">{{ course.title }}</h1>
                    <p class="text-2xs mt-3" v-if="progress < 10">0%</p>
                    <div v-if="progress < 100" class="w-full progress-ccontainer bg-white" :class="{ 'mt-3': progress > 10 }" style="height: 15px">
                        <div class="progress rounded-full bg-gray-800 flex justify-end items-center relative" :style="`width: ${progress}%`" style="height: 15px;">
                            <p class="text-2xs text-black absolute" style="top: -15px; transition: width .5s ease" v-if="progress > 10">{{ progress }}%</p>
                        </div>
                    </div>
                    <div v-if="progress >= 100 & !course.is_certifiable" class="bg-green-500 text-white text-center rounded">Completed!</div>
                    <a :href="`/learn/certificate/${certificate}`" target="_blank" v-else class="inline-block text-center hover:bg-green-600 bg-green-500 mt-3 rounded-full w-full text-white py-1">View Certificate</a>
                </div>
                <div class="sections mb-2">
                    <Section v-for="(section, index) in course.sections" :section="section" :key="section.id" :index="index" ></Section>
                </div>
            </div>
        </div>
        <p></p>
    </section>
</Layout>

</template>

<script setup>

import Layout from "../../Shared/Layout.vue";
import Section from "../../Components/SectionAlternateStyle.vue";
import {computed, ref, provide, onMounted, onUnmounted} from "vue"
import CommentVue from "../../Components/Comment.vue";
import CommentModal from "../../Components/CommentModal.vue";
import VideoScreen from "../../Components/VideoScreen.vue";
import Quiz from "../../Components/Quiz.vue";
import { router } from "@inertiajs/vue3";
import Plyr from "plyr";
import Modal from "../../Classes/Modal";
import NavLink from "../../Components/NavLink.vue";
import axios from "axios";

let props = defineProps({
    course: Object,
    current_content: Object,
    next_content: Object,
    certificate_id: Number,
    is_purchased: Boolean
});
let progress = ref(props.is_purchased ? props.course.tracker.progress : -1);
provide("course", props.course);
provide("current_content", props.current_content);
provide("completed", props.is_purchased ? JSON.parse(props.course.tracker.tracking).map(tracker => tracker.id) : -1);

let comments = ref(props.current_content.comments);
let active = ref(false);
let replying_to = ref();
let replying_name = ref();
let video = ref(props.current_content.content);
let certificate = ref(props.certificate_id);

function toggle(event) {
    active.value = !active.value;
    replying_to.value = event[0];
    replying_name.value = event[1];
}
let isQuiz = computed(() => props.current_content.content_type === '2')

let player;
onMounted(() => {
    player = new Plyr('#player');
    player.source = {
        type: 'video',
        title: 'Example title',
        sources: [
            {
                src: route('video.get', {filename: video.value}),
                type: 'video/mp4',
                size: 720,
            },
            {
                src: `/uploads/${props.current_content.content}`,
                type: 'video/webm',
                size: 1080,
            },
        ],
    }
    async function updateProgress() {
        if(!props.is_purchased) return;
        const status = await axios.post(`/learn/course/${props.current_content.id}/updateTracker/${props.course.id}`);
        certificate.value = status.data[1].certificate_id;
        progress.value = status.data[0];
    }
    player.on('ended', e => {
        let modal = new Modal();
        const status = updateProgress();
        if(props.next_content) {
            modal.oneInput("Do you want to see the next lecture?", function() {
                router.get(`/learn/course/${props.course.slug}/${props.next_content.id}`)
            }, true, "Yes", "")
        } else {
            modal.success("Check back casually to see new content");
        }
    })
})

onUnmounted(() => {
    player.destroy();
})






</script>

<style>

</style>
