<template>
    <Layout>
        <section class="mt-5 create-field container mx-auto relative" style="width: 100%;">
            <CourseForm method="POST" href="/instructor/course/create" :categories="categories"></CourseForm>
        </section>
    </Layout>
</template>

<script setup>

import CourseForm from "../../Components/Essentials/Forms/CourseForm.vue";

let props = defineProps({
    categories: Array
});


</script>

<style>

</style>
