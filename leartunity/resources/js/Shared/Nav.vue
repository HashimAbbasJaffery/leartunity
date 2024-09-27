<script setup>
import NavLink from '../Components/NavLink.vue';
import { usePage } from '@inertiajs/vue3';
import {computed} from "vue"
import axios from 'axios';
import {ref, inject} from "vue";
import { rate } from '../Classes/CurrencyExchange';


const page = usePage();
const user = page.props.auth.user;
const userCurrency = page.props.auth.currency;
let currency = ref(userCurrency.id);
console.log(userCurrency.currency);
const isUser = computed(() => user);
const isGuest = computed(() => !user);
const isAdmin = computed(() => user.role === "admin");
const isTeacher = computed(() => user.role !== "user");

let locales = inject("localeData");

let emit = defineEmits("changeCurrency");

convert(userCurrency.currency, userCurrency.unit)
let rateExchange = ref();
let currencyUnit = ref();

async function convert(locale, unit) {
    const currencyRate = await rate(locale);
    rateExchange.value = currencyRate;
    currencyUnit.value = unit;
}

function changeCurrency() {
    const locale = Array.from(listValue.children).find(child => child.value == currency.value);
    const unit = locale.dataset.unit;
    currencyUnit.value = unit;
    convert(locale.textContent, unit);
    emit('changeCurrency', currency.value)
}

</script>
<template>
  <nav>
    <ul style="position: relative; height: 36px">
    <li>
        <select v-model="currency" name="" id="listValue" class="px-2" @change="changeCurrency">
            <option v-for="locale in locales" :value="locale.id" :data-unit="locale.unit" :key="locale.id">{{ locale.currency }}</option>
        </select>
    </li>
    <li v-if="isAdmin">
    <NavLink href="/admin" v-translate>Admin</NavLink>
    </li>
    <li class="mx-3">
    <NavLink href="/learn" v-translate>My Learning</NavLink>
    </li>
    <li class="mx-3">
    <NavLink href="/courses" v-translate>Courses</NavLink>
    </li>
    <li class="mx-3" v-if="isTeacher">
    <NavLink href="/instructor" v-translate>Instructor</NavLink>
    </li>

    <li class="mx-3">
    <NavLink href="/referrals" v-translate>Referrals</NavLink>
    </li>

    <li class="mx-3 highlighted" v-if="user">
    <NavLink :href="`/profile/${user.id}`">{{ user.name }}</NavLink>
    </li>
    <li class="mx-3" v-if="isGuest">
        <NavLink href="/register">Register</NavLink>
    </li>
    <li class="mx-3 highlighted" v-if="isGuest">
        <NavLink href="/login">Login</NavLink>
    </li>


      <ul class="notification-drop" style="position: relative">
        <li class="item">
          <i
            class="fa fa-bell-o notification-bell"
            style="font-size: 20px"
            aria-hidden="true"
          ></i>
          <div
            class="notify"
            style="
              top: 8px;
              right: 8px;
              position: absolute;
              background: #00ff00;
              width: 15px;
              height: 15px;
              border-radius: 50px;
              border: 3px solid white;
            "
          >
            &nbsp;
          </div>

          <ul
            class="rounded"
            style="
              max-height: 300px;
              overflow: auto;
              border: 1px solid var(--primary);
            "
          >
            <li style="font-size: 12px" class="px-1">
              "No notifications? Maybe they're at a disco party!"🎉
            </li>
          </ul>
        </li>
      </ul>

      <li>
        <NavLink
           style="font-size: 20px"
          class="bold-600 text-xl"
            href="/logout"
            v-if="isUser"
        >
            <i class="fa-solid fa-power-off"></i>
        </NavLink>
      </li>
      <li>
        <NavLink href="/test">{{ Math.round(user.balance * rateExchange) }} {{ currencyUnit }}</NavLink>
      </li>
    </ul>
  </nav>
</template>
