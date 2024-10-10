<template>
    <td class="px-6 py-4">{{ title }}</td>
    <td class="px-6 py-4">{{ category.courses_count }}</td>
    <td class="px-6 py-4">1</td>
    <td class="px-6 py-4">
        <button type="button" @click="changeStatus(category.id)" v-if="is_active" class="active status text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Active</button>
        <button type="button" @click="changeStatus(category.id)" v-else class="status text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Inactive</button>
    </td>

    <td class="px-6 py-4">
        <button type="button" @click="update(category.id, category.category)" class="update-category focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Update</button>
        <button @click="deleteCategory(category.id)" type="button" class="delete-category focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
    </td>
</template>
<script setup>
import {ref, reactive} from "vue";
import Modal from "../Classes/Modal";
import axios from "axios";


let props = defineProps({
    category: Object
})
let title = ref(props.category.category);

let emit = defineEmits(["deleted"]);
let is_active = ref(props.category.status);

const update = (id, category) => {
    const modal = new Modal(category);
    modal.oneInput("Update", async function(result) {
        const status = await axios.put(`/admin/category/${id}/update`, { category: result.value });
        title.value = result.value;
    }, true, "Update");
}

const deleteCategory = async id => {
    const modal = new Modal();
    modal.oneInput(`Are you sure you want to delete ${title.value} Category?`, async function() {
        const data = await axios.post(`/admin/category/${id}/delete`, { _method: "DELETE" });
        emit("deleted");
        modal.success("Successfully Deleted!");
    }, true, "Delete", "");
}

const changeStatus = async id => {
    const data = await axios.put(`/admin/category/${id}/status`, { context: !is_active.value });
    is_active.value = !is_active.value;
}

</script>
