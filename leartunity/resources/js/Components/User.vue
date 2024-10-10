<template>

                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="user flex items-center ">
                            <div class="profile mr-3">
                                <img :src="`/profile/${user?.profile?.profile_pic ?? null}`" height="30" width="30" class="rounded" alt="">
                            </div>
                            <div class="user-detail" style="font-size: 13px;">{{ user.name }}</div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        {{ user.role }}
                    </td>
                    <td class="px-6 py-4">
                        {{ user?.profile?.follows ?? 0 }}
                    </td>
                    <td class="px-6 py-4">
                        {{ user.streak }}
                    </td>
                    <td class="px-6 py-4">
                        {{ moment(user.created_at).fromNow() }}
                    </td>

                    <td class="flex items-center px-6 py-4">
                        <button @click="manageBan(user.id)" v-if="!is_ban && !loading" type="button" data-context="1" data-id="1" class="ban-1 ban-button focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Ban</button>
                        <button @click="manageBan(user.id)" v-else-if="is_ban && !loading" type="button" data-context="0" data-id="1" class="unban-1 ban-button focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Unban</button>
                        <button @click="manageBan(user.id)" v-else type="button" data-context="0" data-id="1" class="unban-1 ban-button focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Processing...</button>
                    </td>
</template>
<script setup>

import moment from 'moment';
import {ref} from "vue";

let props = defineProps({
    user: Object
});

let is_ban = ref(props.user.is_banned);
let loading = ref(false)

const manageBan = async id => {
    loading.value = true;
    let status = await axios.put(`/admin/user/${id}/ban`, { context: !is_ban.value });
    is_ban.value = !status.data;
    loading.value = false;
}

</script>
