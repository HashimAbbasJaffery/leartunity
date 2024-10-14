<template>
  <Layout>
        <main>
            <section id="search-area" class="container mx-auto" style="position: relative;">
                <form class="inline-block">
                    <select v-model="form.type" class="search-type highlighted p-1 mt-4" style="width: 10%;height: 35px;">
                        <option value="categories">Categories</option>
                        <option value="course">Course</option>
                        <option value="teachers">Teachers</option>
                    </select>
                    <input type="text" v-model="form.query" placeholder="Search for anything!" style="border-radius: 0px; border: 1px solid #424242;" id="q" name="" />
                    <div v-if="show_drawer" class="results" style="overflow: auto;max-height: 300px;border-radius: 5px;border: 1px solid black;right: 0px;position: absolute; background: white; width: 89%; top: 115%; padding-left: 10px;">
                        <div v-show="form.query" class="teachers results py-2 flex" v-for="result in results" :key="result.id">
                          <div v-if="form.type !== 'categories'" class="search_thumbnail mr-4">
                            <img :width="meta_data.path === 'profile_pic' ? 50 : 80" :src="`/${meta_data.folder}/${result[meta_data.path]}`" alt="">
                          </div>
                          <p>{{ result[meta_data.title] }}</p>
                        </div>
                    </div>
                </form>
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
                <div v-for="category in categories" :key="category.id" :id="`category-${category.id}`" v-show="current_cat_active === category.category">
                    <div class="grid grid-cols-4 gap-4">
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
import {ref, watch, reactive} from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

import { useDebouncedRef } from "../debounce";

let props = defineProps({
    "categories": String,
    "quote": String
})

let quoteMessage = useDebouncedRef();

watch(quoteMessage, function() {
    const status = axios.post('/admin/change/quote', { quote: quoteMessage.value, _method: "PUT" })
})

let current_cat_active = ref(props.categories[0].category)
let results = ref();
let meta_data = reactive({
  title: "",
  path: "",
  link: "",
  folder: ""
})
let show_drawer = ref(false);

let form = reactive({
    query: "",
    type: "categories"
})

watch(form, async () => {
  if(!form.query.length) {
    show_drawer.value = false;
    results.value = "";
    return;
  }
  results.value = "";
  show_drawer.value = false;
  const status = await axios.get(`/api/search?query=${form.query}&type=${form.type}`);
  results.value = status.data[1];
  meta_data.title = status.data[0];
  meta_data.path = status.data[2];
  meta_data.link = status.data[3];
  meta_data.folder = status.data[4];
  show_drawer.value = true;
})

console.log(props.categories)
</script>

<style>

</style>
