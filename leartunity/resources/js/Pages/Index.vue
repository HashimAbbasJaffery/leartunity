<template>
  <Layout>
    <p>{{ test }}</p>
        <main>
            <section id="search-area" class="container mx-auto" style="position: relative;">
                <select class="search-type highlighted p-1 mt-4" style="width: 10%;height: 35px;">
                  <option value="categories">Categories</option>
                  <option value="course">Course</option>
                  <option value="teachers">Teachers</option>
                </select>
                <input type="text" placeholder="Search for anything!" style="border-radius: 0px; border: 1px solid #424242;" id="q" name="" />
                <div class="results none" style="overflow: auto;max-height: 300px;border-radius: 5px;border: 1px solid black;right: 0px;position: absolute; background: white; width: 89%; top: 115%; padding-left: 10px;">
                  <div class="teachers results py-2">
                    &nbsp;
                  </div>
                </div>
            </section>
            <div>
            <div id="separator" class="container mx-auto mt-4" style="background: black; height: 2px;">&nbsp;</div>
            <section id="banner" style="background: var(--primary);" class="text-center" contenteditable="" @keyup="quoteMessage = $event.target.children[0].textContent">
              <h1 id="sliders" ref="quoteContainer" oninput="contentChanged(this)">
                {{ quote.quote }}
              </h1>
            </section>
          </div>

          <section id="courses" class="container mx-auto">
            <h1 class="text-center">Top Courses</h1>
            <div class="tabs mt-5">
              <ul class="flex space-x-4">
                  <li @click="current_cat_active = category.category" v-for="category in categories" :key="category.id" class="tab" :class="{ 'active': current_cat_active === category.category }">{{ category.category }}</li>
              </ul>
            </div>
              <div v-for="category in categories" :key="category.id" :id="`category-${category.id}`">
                    <div class="grid grid-cols-4 gap-4 courses" v-if="current_cat_active === category.category">
                        <Course v-for="course in category.courses" :course="course" :key="course.id"></Course>
                    </div>
              </div>
          </section>
          <section id="apply-for-teaching" class="container mx-auto flex ">
            <div class="side-image">
              <img src="../../../public/img/sample.jpg" alt="">
            </div>
            <div class="apply">
              <h1>
                Become Teacher
              </h1>
              <p>Start teaching right away, and arrange live sessions</p>
              <div class="flex">
                <button class="mr-1">Apply</button>
                <button style="background: transparent; color: black; border: 1px solid var(--primary)">Learn More</button>
              </div>
            </div>
          </section>
        </main>
</Layout>

</template>

<script setup>
import Layout from "../Shared/Layout.vue";
import Course from "../Components/Course.vue"
import {ref, watch} from "vue";
import { router } from "@inertiajs/vue3";

import { useDebouncedRef } from "../debounce";

let props = defineProps({
    "categories": String,
    "quote": String
})

let quoteMessage = useDebouncedRef();

watch(quoteMessage, function() {
    const status = router.put("/admin/change/quote", { quote: quoteMessage.value });
})

let current_cat_active = ref(props.categories[0].category)
let test = ref();


console.log(props.categories)
</script>

<style>

</style>
