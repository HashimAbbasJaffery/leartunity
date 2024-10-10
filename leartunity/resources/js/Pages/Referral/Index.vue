<template>
<Layout>
    <div class="container mx-auto">
            <div class="referral-link" style="margin: 100px 100px;">
                <h1 class="text-center text-xl">Refer User</h1>
                <div class="link-box" style="display: flex; justify-content: center; width: 100%;">
                    <input type="text" id="link" :value="uri" readonly>
                    <button @click="copyToClipboard()" style="background: black; color: white;" class="px-2" :ref="copyButton" id="copyButton">
                        {{ isCopied ? "Copied" : "Copy" }}
                    </button>
                </div>
            </div>
            <div class="referral-list">
                <h1 class="text-xl mb-3">Referrals</h1>
                <DataTable id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr v-for="referral in referrals" :key="referral.id">
                            <td>{{ referral.name }}</td>
                            <td>{{ referral.email }}</td>
                            <td>{{ referral.balance }} $</td>
                        </tr>
                    </tbody>
                </DataTable>
            </div>
            <div class="benefits mt-5">
                <h1 class="text-xl">Referraal Perks</h1>
                <p>By referring other person, and if they register by your referral link and make a first purchase, then you will get 1$. It applies on every referred person you have but only works in their first purchase</p>
            </div>
        </div>
</Layout>
</template>
<script setup>
import Layout from "../../Shared/Layout.vue";
import { usePage } from "@inertiajs/vue3";
import {ref, onMounted} from "vue";
import DataTable from 'datatables.net-vue3';
import Select from 'datatables.net-select';

let props = defineProps({
    referrals: Object
});

let page = usePage();

let uri = ref(`${route('register')}?id=${page.props.auth.user.id}`);
let isCopied = ref(false);

function copyToClipboard() {
    navigator.clipboard.writeText(uri.value).then(() => {
        isCopied.value = true;
        setTimeout(() => isCopied.value = false, 5000);
    }).catch(err => {
        console.error('Failed to copy: ', err);
    });
}


</script>
