<template>
  <Layout>
    <section class="container mx-auto mt-5">
        <div class="store-section" style="width: 100%;">
            <div class="grid grid-cols-3 gap-4 store-cards">
                <Course v-for="course in courses" :course="course" :key="course.id"></Course>
            </div>
            <div class="load-more_section">
                <button class="highlighted load-more" style="@if(!$courses->hasPages()) display: none; @endif">Load More</button>
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

let props = defineProps({
    courses: Array
})
</script>

<style>

</style>
