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

            <input type="submit" class="mt-1" value="Send Email" style="cursor:pointer;">
            <div class="g-signin2" data-onsuccess="onSignIn"></div>
        </form>
        <Transition name="fade">
            <div v-show="emailDispatched" class="sending-email bg-green-300 w-1/2 mt-3 rounded flex justify-between items-center p-1 mt-7">
                <div class="spinner">
                    <div v-if="emailDispatched" class="lds-dual-ring"></div>
                </div>
                <div class="message">
                    <p>Set back! We are dispatching email.</p>
                </div>
            </div>
        </Transition>

        <Transition name="fade">
            <div v-show="done" class="p-4 sending-email bg-green-300 w-1/2 mt-3 rounded flex justify-around items-center p-1 mt-7">
                <div class="spinner">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg>
                </div>
                <div class="message">
                    <p>Done! Check your inbox</p>
                </div>
            </div>
        </Transition>

    </SessionLayout>
</template>

<script setup>
import SessionLayout from "../../Shared/SessionLayout.vue";
import {ref} from "vue"
import { router } from "@inertiajs/vue3";

let props = defineProps({
    token: String,
})

let form = {
    email: "",
}

let emailDispatched = ref(false);
let done = ref(false);

const hideSpinner = () => {
    emailDispatched.value = false
    done.value = true;
    setTimeout(() => {
        done.value = false
    }, 5000)
}

const submit = () => {
    emailDispatched.value = true;
    const status = router.post("/forgot-password", form, {onSuccess: hideSpinner});
}
</script>

<style scoped>

.lds-dual-ring,
.lds-dual-ring:after {
  box-sizing: border-box;
}
.lds-dual-ring {
  display: inline-block;
  width: 40px;
  color: green;
  height: 40px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 30px;
  height: 30px;
  margin: 8px;
  border-radius: 50%;
  border: 6.4px solid currentColor;
  border-color: currentColor transparent currentColor transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease-in-out;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}


</style>
