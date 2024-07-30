<script setup>
import Layout from "../../Shared/Layout.vue";
import Course from "../../Components/Course.vue";
import {defineProps, onMounted} from "vue"

defineProps({
    categories: Array,
    courses: Array
})


</script>
<template>

<Layout>
    <main>
            <section class="store container mx-auto">
                <aside class="filter-bar">
                    <form action="/api/courses" id="submitFilter" style="display: block;">
                        <div class="category-filter filter">
                            <h1>Categories</h1>
                            <ul class="mt-4">
                                <li v-for="category in categories" :key="category.id">
                                    <label :for="'category-'+category.id">
                                        <input type="checkbox" id="'category-'+category.id" :data-id="category.id" class="category-checkbox mr-2" style="height: 13px; width: 13px;" />
                                        {{ category.category }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="price-range filter mt-3">
                            <h1>Price Range</h1>
                            <div class="range-inputs mt-4">
                                <label>
                                    From ($)
                                    <br />
                                    <input type="number" class="price_range" style="border-radius: 5px; width: 95%; padding-left: 10px;"/>
                                </label>
                                <label>
                                    To ($)
                                    <br />
                                    <input type="number" class="price_range" style="border-radius: 5px; width: 95%; padding-left: 10px;"/>
                                </label>
                            </div>
                        </div>
                        <div class="search-filter filter mt-3">
                            <h1>Search</h1>
                            <div class="search-bar mt-4 flex">
                                <select id="type" class="search-type highlighted p-1 " style="height: 35px; outline: none; width: 30%; font-size: 14px;">
                                    <option>Title</option>
                                    <option>Description</option>
                                </select>
                                <input id="q" type="text" style="border-radius: 0px; outline: none; padding-left: 10px; width: 70%;"/>
                            </div>
                        </div>
                        <input type="submit" value="Apply Filters" class="mt-3"  style="cursor: pointer;width: 100%; border-radius: 5px; font-size: 14px;"/>
                    </form>
                    <input style="background: transparent; color: black;font-size: 14px; cursor: pointer;text-align: center;width: 100%; border-radius: 5px; padding-left: 10px;" type="submit" value="Clear Filters" class="mt-3" id="clear-filter"/>
                </aside>
                <div class="store-section">
                    <div class="grid grid-cols-3 gap-4 store-cards">
                        <Course v-for="course in courses" :key="course.id" :course="course" class="course" />
                    </div>
                    <div class="load-more_section">
                        <button class="highlighted load-more">Load More</button>
                    </div>
                </div>
            </section>
    </main>
</Layout>

</template>
