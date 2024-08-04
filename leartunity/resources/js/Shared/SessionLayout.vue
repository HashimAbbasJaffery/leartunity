<template>

<body>
        <div class="account_not_found animate__animated animate__bounceIn" v-if="$page.props.flash.message">
            <p>{{ $page.props.flash.message }}</p>
        </div>
        <div class="account_not_found animate__animated animate__bounceIn" v-if="false">
            <p>Success</p>
        </div>
    <div class="wrapper flex">
        <div class="vector-art bg-black-400">
            <img src="../../../public/img/login-img.png" height="450"  class="login-cover" alt="">
        </div>

        <div class="login-form">
            <div class="logo text-center">
                <h1>Leartunity.</h1>
                <p>Let's learn together</p>
            </div>
            <slot></slot>
        </div>
    </div>
</body>
</template>

<script setup>

let props = defineProps({
    message: {
        type: String,
        default: ""
    }
})

</script>

<style>

</style>
