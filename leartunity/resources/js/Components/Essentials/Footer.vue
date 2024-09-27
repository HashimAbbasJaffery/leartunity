<script setup>
import { trans } from 'laravel-vue-i18n';
</script>
<template>

  <footer>
    <div class="container mx-auto flex justify-around">
      <div class="first-column column">
        <h1 v-translate>Learning Materials</h1>
        <nav>
          <ul>
            <li v-translate>Courses</li>
            <li v-translate>Books</li>
            <li v-translate>Live Sessions</li>
            <li v-translate>Teachers</li>
          </ul>
        </nav>
      </div>
      <div class="second-column column">
        <h1 v-translate>Website Information</h1>
        <nav>
          <ul>
            <li v-translate>Privacy Policy</li>
            <li v-translate>Contact Us</li>
            <li v-translate>Feedbacks</li>
          </ul>
        </nav>
      </div>
      <div class="fourth-column column">
        <h1 v-translate>Newsletter</h1>
        <div class="newsletter">
          <input type="text" :placeholder="trans('Enter your email')"/>
          <button v-translate>Subscribe</button>
        </div>
      </div>
      <div class="third-column column">
        <h1>Leartunity.</h1>
      </div>
    </div>
  </footer>
</template>
