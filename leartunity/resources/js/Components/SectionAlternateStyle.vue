<template>
<div @mouseleave="caretVisible = false" @mouseenter="caretVisible = true" class="mb-2 section flex justify-between items-center" @click="toggleSection = !toggleSection">
    <div class="container flex w-full justify-start">
        <p style="border-right: 1px solid black" class="text-center w-1/6 pr-2 font-bold">{{ convertToRoman(index + 1) }}</p>
        <h1 class="pl-7" style="text-align: right;">{{ section.section_name.substring(0, 25) }}{{ section.section_name.length > 25 ? "..." : "" }}</h1>
    </div>
    <div class="icon mx-3">
        <i class="fa-solid" style="width: 10px; box-sizing:content-box" v-show="caretVisible" :class="{ 'fa-caret-down': !toggleSection, 'fa-caret-up': toggleSection }"></i>
    </div>
</div>
<div class="lessons" v-if="toggleSection">
    <LessonComponent v-for="content in contents" :content :key="content.id"></LessonComponent>
</div>
</template>

<script setup>
import { convertToRoman } from '../Helpers/Helper';
import LessonComponent from './LessonComponent.vue';
import {ref} from "vue"

let props = defineProps({
    section: Object,
    index: Number
});

let contents = props.section.contents;
let toggleSection = ref(false);
let caretVisible = ref(false);


</script>

<style>

</style>
