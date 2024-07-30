<script setup>
import NavLink from '../Components/NavLink.vue';

</script>
<template>
  <nav>
    <ul style="position: relative; height: 36px">
      <li>
        <NavLink href="/admin">Admin</NavLink>
      </li>
      <li class="mx-3">
        <NavLink href="#">My Learning</NavLink>
      </li>
      <li class="mx-3">
        <NavLink href="/courses">Courses</NavLink>
      </li>
      <li class="mx-3">
        <NavLink href="/instructor">Instructor</NavLink>
      </li>

      <li class="mx-3">
        <NavLink href="/referrals">Referrals</NavLink>
      </li>

      <li class="mx-3 highlighted">
        <NavLink href="/profile/1">Hashim</NavLink>
      </li>
      <li class="mx-3">
        <NavLink href="/register">Register</NavLink>
      </li>
      <li class="mx-3 highlighted">
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
        >
            <i class="fa-solid fa-power-off"></i>
        </NavLink>
      </li>
      <li>
        <NavLink href="/test">1</NavLink>
      </li>
    </ul>
  </nav>
</template>
