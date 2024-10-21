<template>

<section id="admin-header" class="my-4 container mx-auto rounded mb-2">
            <ul class="flex justify-center">
                <li>
                    <NavLink class="py-3 px-4 block admin-nav" :class="{ 'header-active': $route().current() === 'home.admin' }" :href="`/admin`">
                        <i class="fa-solid fa-gauge"></i>
                        Dashboard
                    </NavLink>
                </li>
                <li>
                    <NavLink class="py-3 px-4 block admin-nav" :class="{ 'header-active': $route().current() === 'admin.user' }" :href="`/admin/users`">
                        <i class="fa-solid fa-user"></i>
                        Users
                    </NavLink>
                </li>
                <li>
                    <NavLink class="py-3 px-4 block admin-nav" :class="{ 'header-active': $route().current() === 'category.index' }" :href="`/admin/categories`">
                        <i class="fa-solid fa-list"></i>
                        Categories
                    </NavLink>
                </li>
                <li>
                    <NavLink class="py-3 px-4 block admin-nav" :class="{ 'header-active': $route().current() === 'category.index' }" :href="$route('application')">
                        <i class="fa-solid fa-envelope"></i>
                        Applications
                    </NavLink>
                </li>
                <li>
                    <NavLink class="py-3 px-4 block admin-nav" :class="{ 'header-active': $route().current() === 'admin.setting' }" :href="`/admin/settings`">
                        <i class="fa-solid fa-gear"></i>
                        Settings
                    </NavLink>
                </li>
            </ul>
        </section>


</template>

<script setup>
import NavLink from './NavLink.vue';
import {onMounted} from "vue";




</script>
