<script setup>
import NavLink from '../Components/NavLink.vue';
import { usePage } from '@inertiajs/vue3';
import {computed} from "vue"

const page = usePage();
const user = page.props.auth.user;
const isUser = computed(() => user);
const isGuest = computed(() => !user);
const isAdmin = computed(() => user.role === "admin");
const isTeacher = computed(() => user.role !== "user");
</script>
<template>
  <nav>
    <ul style="position: relative; height: 36px">
      <li v-if="isAdmin">
        <NavLink href="/admin">Admin</NavLink>
      </li>
      <li class="mx-3">
        <NavLink href="#">My Learning</NavLink>
      </li>
      <li class="mx-3">
        <NavLink href="/courses">Courses</NavLink>
      </li>
      <li class="mx-3" v-if="isTeacher">
        <NavLink href="/instructor">Instructor</NavLink>
      </li>

      <li class="mx-3">
        <NavLink href="/referrals">Referrals</NavLink>
      </li>

      <li class="mx-3 highlighted" v-if="user">
        <NavLink href="/profile/1">{{ user.name }}</NavLink>
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
        <NavLink href="/test">{{ user.balance }}</NavLink>
      </li>
    </ul>
  </nav>
</template>
