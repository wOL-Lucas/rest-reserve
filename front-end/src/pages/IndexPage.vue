<template>
  <q-page class="row items-center justify-evenly">
  </q-page>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

onMounted(() => {
  if (!localStorage.getItem('accessToken')) {
    router.push('/login');
  }
});
</script>
