<template>
    <Layout>
     <section id="add-section" class="container mx-auto mt-3">
        <h1 style="font-size: 25px; font-weight: 500;">Add Section</h1>

         <div class="course-sections mb-3">
                <Section :resumable="resumable" v-for="section in sections" :key="section.id" :section="section" instructor></Section>
                 <div class="none contents" id="content-id">
                     <div class="core-contents" id="core-contents-id">
                             <a href="#" style="margin-bottom: 5px" class="content flex justify-between block">
                                 <p style="text-decoration: underline; margin-bottom: 8px;">Title</p>
                                 <div class="right-side-info flex items-center">
                                     <!-- @if($content->content_type == 1) -->
                                         <p class="mr-2">54</p>
                                     <!-- @else -->
                                         <div class="mr-2">
                                         <p><span class="mr-1">1</span>Question(s)</p></div>
                                     <!-- @endif -->
                                     <form method="POST" action="#">
                                         <button class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                             Delete
                                         </button>
                                     </form>
                                     <button id="content-id" class="content-update bg-blue-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                         Update
                                     </button>
                                 </div>
                             </a>
                     </div>
                     <div class="options" style="display: flex;">
                         <a href="#" id="contents-[id]"
                             class="create-content create-course rounded text-center py-2"
                             style="width:100%; display: inline-block">
                             <i class="fa-solid fa-plus p-3 rounded-full"
                                 style="background: var(--primary); color: white;"></i>
                         </a>
                         <a href="#" id="contents-#"
                             style="width: 10%; margin-left: 1%; display: flex; align-items: center; justify-content: center; border-color: #9370DB; color: #9370DB; width:100%; display: inline-block"
                             class="create-content create-course rounded text-center py-2">
                             Add Quiz
                         </a>
                     </div>
                 </div>
         </div>
         <a href="#" @click="addSection" class="create-section create-course rounded text-center py-2"
             style="width:100%; display: inline-block">
             <i class="fa-solid fa-plus p-3 rounded-full" style="background: var(--primary); color: white;"></i>
         </a>
        <button @click="changeAwardableStatus" v-if="is_awardable" type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Award Certificates</button>
        <button @click="changeAwardableStatus" v-else type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">No Certificates Awarding</button>
     </section>

    </Layout>
</template>

<script setup>
import Layout from "../../../Shared/Layout.vue";
import Section from "../../../Components/Section.vue"
import Modal from "../../../Classes/Modal";
import {ref} from "vue"
import Resumable from "../../../Classes/Resumable";
import axios from "axios";

let props = defineProps({
    sections: Array,
    course: Object,
    csrf: String,
})

let sections = ref(props.sections);
let resumable = new Resumable();
let is_awardable = ref(props.course.is_certifiable);

const changeAwardableStatus = async () => {
    const status = await axios.put(route('course.is_awardable', { id: props.course.id }))
    if(status.data === 1) is_awardable.value = !is_awardable.value;
}

const addSection = () => {
    let modal = new Modal();
    modal.oneInput("Enter Section Name", async function(result) {
        const section_name = result.value;
        try {
            const data = await axios.post(`/instructor/section/${props.course.slug}/create`, {section_name});
            sections.value = data.data;
        } catch(err) {
            console.log(err);
        }
    })
}

</script>

<style>

</style>
