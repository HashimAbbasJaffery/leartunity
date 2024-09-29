<template>
  <Layout>
    <section class="container mx-auto mt-5">
        <div class="store-section" style="width: 100%;">
            <div class="grid grid-cols-3 gap-4 store-cards">
                <Course @deleted="deleted" v-for="course in courses.data" :course="course" :key="course.id"></Course>
            </div>
            <div class="pagination-pages mb-4" v-if="courses.data.length">
                <ul class="flex">
                    <li @click="pagination(link.url)" v-for="link in links" :key="link.label" :style="{ opacity: (link.active || !link.url) ? 0.5 : 1 }" class="ml-2 text-white px-4 rounded cursor-pointer" style="background: var(--primary);" v-html="link.label"></li>
                </ul>
            </div>
        </div>
    </section>
    <section id="add-course" class="container mx-auto">
        <NavLink href="/instructor/course/create" class="create-course rounded text-center py-2" style="width:100%; display: inline-block">
            <i class="fa-solid fa-plus p-3 rounded-full" style="background: var(--primary); color: white;"></i>
        </NavLink>
    </section>
</Layout>
</template>

<script setup>
import Layout from "../../Shared/Layout.vue"
import Course from "../../Components/Course.vue"
import NavLink from "../../Components/NavLink.vue"
import axios from "axios";
import {ref} from "vue";

let props = defineProps({
    courses: Array
})
let courses = ref(props.courses);
const links = ref(props.courses.links);

const pagination = async url => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
    let pageCourses = await axios.get(url);
    pageCourses = pageCourses.data;
    links.value = pageCourses.links;
    console.log(pageCourses.links);
    courses.value = pageCourses;
}

let deleted = () => {
    let url = `${props.courses.path}?page=${props.courses.current_page}`;
    pagination(url)
}
</script>

<style>

</style>
