<template>
    <Layout>
        <section class="mt-5 create-field container mx-auto relative" style="width: 100%;">
            <CourseForm :course="course" :href="`/instructor/course/${props.course.slug}/create`" :categories="categories"></CourseForm>
        </section>
    </Layout>
</template>

<script setup>

import CourseForm from "../../Components/Essentials/Forms/CourseForm.vue";
import Layout from "../../Shared/Layout.vue"

let props = defineProps({
    course: Array,
    categories: Array
});


</script>

<style>

</style>
