<template>

<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th v-for="(title, index) in titles" :key="index" scope="col" rowspan="1" class="px-6 py-3" style="width: 10% !important;">
                    {{ title }}
                </th>
            </tr>
        </thead>
        <tbody>
            <slot></slot>
        </tbody>
        <div class="pagination-pages mb-4" >
            <slot name="pagination"></slot>
        </div>
    </table>
</template>
<script setup>

let props = defineProps({
    titles: Array,
    data: Object
})




</script>
