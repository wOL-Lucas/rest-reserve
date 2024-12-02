<template>
  <q-page class="row flex-start q-pa-lg q-gutter-md">
    <q-carousel class="half-width min-height-300" animated v-model="slide" navigation infinite :autoplay="autoplay"
      arrows transition-prev="slide-right" transition-next="slide-left" @mouseenter="autoplay = false"
      @mouseleave="autoplay = true">
      <q-carousel-slide v-for="image in foodImages" :key="foodImages.indexOf(image)" :name="foodImages.indexOf(image)">
        <q-img fit="cover" class="big-border-radius max-height-400 fit" :src="image">
        </q-img>
        <PrimaryButton class="z-max absolute-bottom-right q-mr-lg q-mb-lg cursor-pointer" rounded label="Ver menu"
          @click="router.push('/menu')" />
      </q-carousel-slide>
    </q-carousel>
  </q-page>
</template>

<script setup lang="ts">
import PrimaryButton from 'src/components/button/PrimaryButton.vue';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const slide = ref(0);
const autoplay = ref(true);

onMounted(() => {
  if (!localStorage.getItem('accessToken')) {
    router.push('/auth/login');
  }
});

const foodImages = [
  'https://media.istockphoto.com/id/1428412216/photo/a-male-chef-pouring-sauce-on-meal.jpg?s=612x612&w=0&k=20&c=8U3mrgWsuB7pB8axtGj89MXRkHDKodEli9F6wKgPT4A=',
  'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/05/d4/83/3f/fast-food-restaurant.jpg?w=800&h=-1&s=1',
  'https://cdn.prod.website-files.com/60414b21f1ffcdbb0d5ad688/65bd3f2ed08408ced197152d_restaurant-terms.jpg',
];
</script>
