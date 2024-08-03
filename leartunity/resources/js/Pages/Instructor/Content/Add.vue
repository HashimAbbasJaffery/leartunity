<template>
    <Layout>
     <div class="progression" style="padding: 10px;position: fixed; margin: 0 auto; top: 10px; right: 10px;">
         <div class="progress-bar none" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="--value:5"></div>
     </div>
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
     </section>
    </Layout>
</template>

<script setup>
import Layout from "../../../Shared/Layout.vue";
import Section from "../../../Components/Section.vue"
import Modal from "../../../Classes/Modal";
import {ref} from "vue"
import Resumable from "../../../Classes/Resumable";

let props = defineProps({
    sections: Array,
    course: Object,
    csrf: String,
})

let sections = ref(props.sections);
let resumable = new Resumable();

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
