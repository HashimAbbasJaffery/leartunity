<script setup>
import { rate } from "../Classes/CurrencyExchange";
import Switch from "./Essentials/Switch.vue";
import NavLink from "./NavLink.vue"
import Instructor from "./Instructor.vue";
import { usePage } from "@inertiajs/vue3";
import PilllMessage from "./Messages/PilllMessage.vue";
import {computed} from "vue"
import { secondsToHms } from "../Helpers/Helper";
import {ref, inject, watch, nextTick} from "vue";
import Modal from "../Classes/Modal";
import { router } from "@inertiajs/vue3";


let props = defineProps({
    course: Object
})


const page = usePage();
const user = page.props.auth.user;
let currency = inject("currency")



let unit = inject("unit");
const isOwner = computed(() => user.id === props.course.author_id);
convert(currency.value?.currency ?? currency.value[0]?.currency);

let userCurrencyRate = ref();
let isDeleted = ref(false);

async function convert(unit) {
    const currencyRate = await rate(unit);
    console.log(currencyRate);
    userCurrencyRate.value = currencyRate;
}

let emit = defineEmits(["changeUnit", "deleted"]);

watch(currency, function(value) {
    console.log(value);
    convert(value[0].currency);
    unit.value = value[0].unit;
    emit("changeUnit", unit.value);
});


const purchases = props.course.purchases;
console.log(purchases);
console.log(user);
let isPurchased = computed(() => purchases.filter(purchase => purchase.user_id === user.id).length > 0);


const deleteCourse = () => {
    const modal = new Modal();
    modal.oneInput("Sure you want to delete? No take-backs!", async () => {
        const data = await axios.post(`/instructor/course/${props.course.id}`, { _method: 'DELETE' });
        emit("deleted", props.course.slug);
    }, true, "Delete", null);
}



</script>
<template>
    <div class="course" v-if="!isDeleted">
        <div class="course-header" style="position: relative;">
                    <Switch v-if="isOwner && !$route().current('home')" :active="course.status" :id="course.id"/>
                    <div style="position: absolute; bottom: 10px; right: 10px;" class="flex">
                        <!-- <NavLink v-if="isOwner" ref="delButton" method="DELETE" :href="`/instructor/course/${course.slug}/delete`" class="mr-2 text-white px-2 rounded bg-red-500 hover:bg-red-600" as="button" v-translate>Delete</NavLink> -->
                        <button v-if="isOwner && !$route().current('home')" @click="deleteCourse" ref="delButton" class="mr-2 text-white px-2 rounded bg-red-500 hover:bg-red-600" as="button" v-translate>Delete</button>
                        <NavLink v-if="isOwner & !$route().current('home')" :href="`/instructor/course/${course.slug}/edit`" class="text-white px-2 rounded bg-blue-500 hover:bg-blue-600" as="button" v-translate>Update</NavLink>
                    </div>
                <PilllMessage class="bg-black text-white" v-if="isPurchased" v-translate>Purchased</PilllMessage>
                <img v-if="course.thumbnail" :src="'/course/'+course.thumbnail" style="border-radius: 10px;" height="600" width="400" alt="">
                <img v-if="!course.thumbnail" src="https://placehold.co/600x400" height="600" width="400" alt="">
        </div>
        <Instructor href="#" :image="course.author?.profile?.profile_pic ?? null" :name="course.author.name" :rating="props.course.reviews?.stars ?? null"/>

        <div class="course-detail mt-4">
            <div class="course-description">
                <h1 style="font-size: 15px; font-weight: bold; margin-bottom: 5px;">
                    {{ course.title }}
                </h1>
                {{ course.description.substring(0, 80) }}
            </div>
            <div class="course-options mt-2 space-x-2">
                <a :href="`/checkout/${course.stripe_id}`" v-if="!isPurchased" v-translate>Enroll</a>

                <NavLink style="margin-right: 5px;" :href="`/course/${course.slug}`" v-translate>See More</NavLink>
                <NavLink style="margin-right: 5px;" v-if="isOwner && !$route().current('home')" :href="`/instructor/course/${course.slug}`" v-translate>Manage</NavLink>
            </div>
            <div class="course-price flex justify-between">
                <p>{{ Math.round(course.price * userCurrencyRate) }} {{ unit }}</p>
                <p>{{ secondsToHms(course.contents_sum_duration) ? secondsToHms(course.contents_sum_duration) : "No Content Yet!" }}</p>
            </div>
        </div>
    </div>
</template>
