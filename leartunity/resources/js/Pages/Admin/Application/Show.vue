<template>
    <Layout>
        <main class="container mx-auto mt-3">
            <p>Username: <span class="inline-block">{{ application.user.name }}</span></p>
            <p>Qualification: <span class="inline-block">{{ application.qualification }}</span></p>
            <p>Cover Letter: <span class="inline-block">{{ application.cover_letter }}</span></p>
            <a target="_blank" :href="$route('application.file.download', { file_name: application.supporting_file })" type="button" class="mt-3 focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Download Document</a>
            <div class="actions">
                <NavLink method="PATCH" :href="$route('application.approve', { application: application.id })" type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Approve!</NavLink>
                <NavLink method="PATCH" :href="$route('application.reject', { application: application.id })" type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Reject!</NavLink>
            </div>


        </main>
    </Layout>
</template>
<script setup>

import Layout from '../../../Shared/Layout.vue';
import NavLink from '../../../Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    application: Object
});

</script>
