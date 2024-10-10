<template>
    <SessionLayout>

        <div v-if="referrer" class="p-4 text-sm text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300" role="alert">
            You are being referred by <span class="font-medium">{{ referrer.name }}</span>
        </div>
        <form @submit.prevent="submit" method="POST" style="display: flex; flex-direction: column;">
            <input
                id="name"
                type="text"
                class="rounded"
                name="name"
                :class="{ 'invalid': $page.props.errors.name }"
                placeholder="Name"
                v-model="form.name"
            >
            <p class="err-message mb-3">{{ $page.props.errors.name }}</p>
            <input
                id="email"
                type="email"
                name="email"
                placeholder="Type Email"
                class="rounded"
                :class="{ 'invalid': $page.props.errors.email }"
                v-model="form.email"
            >
            <p class="err-message">{{ $page.props.errors.email }}</p>

            <input
                type="password"
                name="password"
                placeholder="Password"
                class="rounded mt-2 rounded"
                :class="{ 'invalid': $page.props.errors.password }"
                v-model="form.password"
            >
            <p class="err-message mb-4">{{ $page.props.errors.password }}</p>
            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirm Password"
                class="rounded"
                :class="{ 'invalid': $page.props.errors.password }"
                v-model="form.password_confirmation"
            >
            <input type="hidden" name="referral_id" v-model="form.referred_by">
            <p class="err-message mb-4">{{ $page.props.errors.password }}</p>
            <input type="submit" class="mt-1" value="Register" style="cursor:pointer;">
            <div class="g-signin2" data-onsuccess="onSignIn"></div>
        </form>
    </SessionLayout>
</template>

<script setup>
import SessionLayout from "../../Shared/SessionLayout.vue";
import { router } from "@inertiajs/vue3";

let props = defineProps({
    token: String,
    referrer: Object
})

let form = {
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    referred_by: props.referrer.id
}

const submit = () => {
    const status = router.post("/register", form);
}
</script>

<style>

</style>
