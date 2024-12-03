<template>
  <q-page class="q-pa-md">
    <div v-for="(item, index) in items" :key="index"
      class="column big-border-radius default-box-shadow q-mx-xl q-my-lg q-pa-md scale-on-hover flex-center text-h5"
      @click="goTo(item.to)">
      <q-icon :name="item.icon" size="md" class="text-primary" />
      <p>{{ item.label }}</p>
    </div>
  </q-page>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const items = ref(
  [
    { label: 'Reservar', icon: 'calendar_month', to: 'create' },
    { label: 'Ver reservas', icon: 'receipt_long', to: 'list' }
  ]
)
const goTo = (path: string) => router.push(path)
</script>
