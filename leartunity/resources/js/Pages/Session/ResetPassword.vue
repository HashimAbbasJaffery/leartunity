<template>
    <SessionLayout>
        <form @submit.prevent="submit" method="POST" style="display: flex; flex-direction: column;">
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
            <p class="err-message mb-4">{{ $page.props.errors.password }}</p>
            <input type="submit" class="mt-1" value="Reset Password" style="cursor:pointer;">
            <div class="g-signin2" data-onsuccess="onSignIn"></div>
        </form>
    </SessionLayout>
</template>

<script setup>
import SessionLayout from "../../Shared/SessionLayout.vue";
import { router } from "@inertiajs/vue3";

let props = defineProps({
    token: String,
})

let form = {
    name: "",
    email: "",
    password: "",
    token: props.token
}

const submit = () => {
    const status = router.post("/reset-password", form);
}
</script>

<style>

</style>
