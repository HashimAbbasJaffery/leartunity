<template>
    <SessionLayout>
        <form @submit.prevent="submit" method="POST" style="display: flex; flex-direction: column;">
            <input
                id="email"
                type="email"
                name="email"
                placeholder="Type Email"
                :class="{ 'invalid': $page.props.errors.email }"
                v-model="form.email"
            >
            <p class="err-message">{{ $page.props.errors.email }}</p>

            <input
                type="password"
                name="password"
                placeholder="Password"
                class="rounded mt-2 mb-2"
                :class="{ 'invalid': $page.props.errors.password }"
                v-model="form.password"
            >
            <p class="err-message mb-4">{{ $page.props.errors.password }}</p>
            <input type="submit" class="mt-1" :disabled="isProcessing" :value="isProcessing ? 'Logging in' : 'Log in'" style="cursor:pointer;">
            <div class="g-signin2" data-onsuccess="onSignIn"></div>
        </form>
    </SessionLayout>
</template>

<script setup>
import SessionLayout from "../../Shared/SessionLayout.vue";
import { router } from "@inertiajs/vue3";
import {ref} from "vue";
import { usePage } from "@inertiajs/vue3";

let props = defineProps({
    token: String,
})

let isProcessing = ref(false);

let form = {
    email: "",
    password: "",
}

const page = usePage();

const submit = async () => {
    isProcessing.value = true;
    const status = router.post("/login", form);
    const keys = Object.keys(page.props.errors);
    if(keys.length) isProcessing.value = false;
}
</script>

<style>

</style>
