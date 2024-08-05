<template>

<section id="follows" class="flex mb-3">
    <p class="mr-2"><span id="follower-count">{{ followers }} </span> Followers</p>
    <button type="submit" :disabled="isDisabled" class="transition delay-150 flex justify-between items-center px-4 py-1 follow-button highlighted px-2 bg-red-500 disabled:cursor-not-allowed hover:bg-red-600 disabled:bg-red-300" @click="action">
        <span v-if="!isDisabled">{{ isFollowed ? "Unfollow" : "Follow" }}</span>
        <div v-else class="lds-dual-ring"></div>
    </button>
</section>

</template>

<script setup>
import {ref} from "vue"
import axios from "axios";

let props = defineProps({
    followers: Number,
    id: Number,
    isFollowed: Boolean
})
let followers = ref(props.followers);
let isFollowed = ref(props.isFollowed);
let isDisabled = ref(false);

const action = async () => {
    isDisabled.value = true;
    const data = await axios.post(`/user/${props.id}/follow`)
    followers.value = data.data.message;
    isFollowed.value = !isFollowed.value;
    isDisabled.value = false;
}

Echo.channel(`follower.${props.id}`)
    .listen('FollowerCounter', (e) => {
            console.log("update");
            followers.value = e.counts;
    });

</script>

<style scoped>


.lds-dual-ring,
.lds-dual-ring:after {
  box-sizing: border-box;
}
.lds-dual-ring {
  display: inline-block;
  width: 20px;
  height: 20px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 20px;
  height: 20px;
  margin: 0px;
  border-radius: 50%;
  border: 6.4px solid currentColor;
  border-color: currentColor transparent currentColor transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}



</style>
