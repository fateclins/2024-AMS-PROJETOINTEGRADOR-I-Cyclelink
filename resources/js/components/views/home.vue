<template>
  <div class="h-screen w-full bg-slate-200 dark:bg-slate-900 flex flex-col justify-center items-center">
    <navbar />
  </div>
</template>

<script>
import navbar from '../navbar/navbar.vue';

export default {
  name: 'Home',
  components: {
    navbar,
  },
};
</script>
