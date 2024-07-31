<template>
  <li>
    <label :for="'category-'+category.id">
        <input type="checkbox" v-model="checked" @change="emit('update:modelValue', test(modelValue, category.id))" ref="checkbox" :id="'category-'+category.id" :data-id="category.id" class="category-checkbox mr-2" style="height: 13px; width: 13px;" />
        {{ category.category }}
    </label>
    </li>
</template>

<script setup>
import {defineProps, ref, defineEmits, watch, inject} from "vue"

let checkbox = ref();
let checked = ref(false);

let props = defineProps({
    category: Object,
    modelValue: Array,
    clear: Boolean
})


let emit = defineEmits(["update:modelValue", "revertclearflag"]);
function test(value, category) {
    let restCategories = value.filter(cat => cat !== category);
    if(checked.value) {
        restCategories.push(category)
    }
    return restCategories;
}

let clear = inject("clear");
watch(clear, function() {
    checkbox.value.checked = false;
})







</script>

<style>

</style>
