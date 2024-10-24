<template>
<Layout>
    <main class="container mx-auto">
        <div class="teachers flex flex-wrap mt-5">
            <div v-for="teacher in teachers" :key="teacher.id" class="teacher-wrappper w-4/12 p-1">
                <div class="teacher rounded" style="border: 1px solid black;">
                    <div class="teacher-header">
                        <img width="100" :src="`${teacher.profile.profile_pic ? '/profile/' + teacher.profile.profile_pic : 'https://placehold.co/100x100'}`" class="rounded-full mx-auto" alt="">
                    </div>
                    <main class="teacher-body text-center text-sm mt-3">
                        <p>Name: {{ teacher.name }}</p>
                        <p>Courses: {{ teacher.courses.length }}</p>
                        <p>Followers: {{ teacher.profile.follows }}</p>
                    </main>
                    <div class="teacher-footer">
                        <NavLink as="button" :href="$route('user.profile', { id: teacher.id })" type="button" class="text-center w-full mt-3 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">See Profile</NavLink>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="next_link.url" class="load-more text-center w-full mt-3">
            <button :disabled="loading" @click="load_more" type="button" class=" disabled:bg-gray-400 disabled:cursor-not-allowed text-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                <span class="flex items-center justify-between w-full">
                    <p class="mr-3">Load More</p>
                    <span v-if="loading" class="loader-spinner"></span>
                </span>
            </button>
        </div>

    </main>
</Layout>
</template>
<script setup>

import { computed, onMounted } from 'vue';
import Layout from '../Shared/Layout.vue';
import NavLink from "../Components/NavLink.vue"
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    teachers: Array
})

const teachers = ref(props.teachers.data);
const links = ref(props.teachers.links);
const loading = ref(false);

const next_link = computed(() => links.value[links.value.length - 1]);

const load_more = async () => {
    loading.value = true;
    const status = await axios.get(next_link.value.url);
    teachers.value.push(...status.data.data);
    links.value = status.data.links;
    loading.value = false;
}

onMounted(() => {
    console.log(next_link.value);
})


</script>

<style scoped>
.loader-spinner {
  width: 22px;
  height: 22px;
  display: inline-block;
  position: relative;
}
.loader-spinner::after,
.loader-spinner::before {
  content: '';
  box-sizing: border-box;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  border: 2px solid #FFF;
  position: absolute;
  left: 0;
  top: 0;
  animation: animloader-spinner 2s linear infinite;
}
.loader-spinner::after {
  animation-delay: 1s;
}

@keyframes animloader-spinner {
  0% {
    transform: scale(0);
    opacity: 1;
  }
  100% {
    transform: scale(1);
    opacity: 0;
  }
}

</style>
