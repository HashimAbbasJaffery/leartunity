<script setup>
import Nav from '../../Shared/Nav.vue';
import NavLink from '../NavLink.vue';
import {inject, watchEffect,} from "vue"
import { usePage } from '@inertiajs/vue3';


let userCurrency = inject("currency");
let locale = inject("locale");




const page = usePage();
const user = page.props.auth.user;

async function changeCurrency(currency) {
    const status = await axios.post(`user/${user.id}/changeCurrency`, { currency });
    userCurrency.value = status.data.currency;
    locale.value = currency;
}


</script>
<template>
    <header class="flex top-header container mx-auto mt-4">
      <div class="logo">
        <NavLink href="/"><h1>Leartunity.</h1></NavLink>
      </div>
      <Nav @changeCurrency="changeCurrency($event)"/>
      </header>
</template>
