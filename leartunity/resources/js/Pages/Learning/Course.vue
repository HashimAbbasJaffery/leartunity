<template>


<Layout>
    <CommentModal @addCourse="comments = $event" :replying_name :replying_to @hide="active = false" :active></CommentModal>
    <div class="progress {{ $course->tracker->progress >= 100 ? '' : 'none'}} container mx-auto download-certificate py-3 px-2 rounded" style="bottom: 10px; left: 10px;background: #15F5BA; position: fixed; width: 50%; z-index: 2">
        You Have completed this course! Download your certificate from <a href="#" style="text-decoration: underline;">Here</a>
    </div>
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
                    <video id="player">
                        <source class="video" src="#" type="video/mp4" />
                        <source class="video" src="#" type="video/webm" />
                        <!-- Captions are optional -->
                    </video>
                    <div class="content-quiz" v-if="isQuiz">
                        <div class="description">
                            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <span class="font-medium">That's fantastic! Your score of 1% on the quiz shows you've mastered the material.</span>
                            </div>
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">1% isn't the end! Keep practicing, you've got this!</span>
                            </div>
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">You need to score 1% in order to be eligible for certification...</span>
                                </div>
                                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                    <span class="font-medium">You have Passed the Exam with score of 11%</span>
                                </div>
                        </div>
                        <div class="questions">
                            <form method="POST"  name="submitQuiz" style="display: inline-block;" id="submitQuiz" action="#">
                                    <h1 class="text-xl font-bold mb-2">Question No. 1</h1>

                                        <div class="question mb-8">
                                            <p>The Question</p>
                                            <ul class="mt-3">
                                                <li><input class="mr-2" type="radio" name="1" value="1">True</li>
                                                <li><input class="mr-2" type="radio" name="1" value="0">False</li>
                                            </ul>
                                        </div>

                                        <div class="question mb-8">

                                            <p>The Question</p>
                                            <ul class="mt-3">

                                                <li><input class="mr-2" value="f">test</li>
                                            </ul>
                                        </div>
                                    <input type="submit" value="Submit" style="border-radius: 0px; width: 20%; cursor: pointer;">
                                </form>

                        </div>
                    </div>
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
                <div class="sections mb-2">
                    <Section v-for="(section, index) in course.sections" :section="section" :key="section.id" :index="index"></Section>
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
import {computed, ref, provide} from "vue"
import CommentVue from "../../Components/Comment.vue";
import CommentModal from "../../Components/CommentModal.vue";

let props = defineProps({
    course: Object,
    current_content: Object,
})

// console.log(props.current_content.comments[0].replies);

provide("course", props.course);
provide("current_content", props.current_content);

let comments = ref(props.current_content.comments);
let active = ref(false);
let replying_to = ref();
let replying_name = ref();


function toggle(event) {
    active.value = !active.value;
    replying_to.value = event[0];
    replying_name.value = event[1];
}
let isQuiz = computed(() => props.current_content.content_type === '2')


</script>

<style>

</style>
