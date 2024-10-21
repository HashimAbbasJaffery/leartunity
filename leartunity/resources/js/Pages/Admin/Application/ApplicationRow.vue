<template>
    <td class="px-6 py-4">{{ application.user.name }}</td>
    <td class="px-6 py-4">{{ application.fullname }}</td>
    <td class="px-6 py-4" style="text-transform: capitalize;">{{ application.qualification }}</td>
    <td class="px-6 py-4">
        <NavLink :href="$route('application.show', { application: application.id })" type="button" class="active status text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">View</NavLink>
    </td>

</template>
<script setup>
import NavLink from '../../../Components/NavLink.vue';

let props = defineProps({
    application: Object
})


</script>
