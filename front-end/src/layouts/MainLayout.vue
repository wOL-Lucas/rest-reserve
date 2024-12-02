<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>

        <q-toolbar-title class="text-center">
          Reserva de restaurante
        </q-toolbar-title>

      </q-toolbar>
    </q-header>

    <q-drawer bordered mini show-if-above class="animated" :mini-width="75" :model-value="true">
      <q-tabs vertical v-model="tab" class="bg-grey-2" active-color="black" indicator-color="black" switch-indicator>
        <div class="row full-width flex-center q-ma-md">
          <q-img fit="fill" width="50%" height="50%" src="/icons/restaurant.png" class="logo__img" />
        </div>
        <q-route-tab name="home" icon="img:icons/home.png" to="/">
          <q-tooltip anchor="center right" self="center left" :offset="[10, 10]" class="text-subtitle2 bg-secondary">
            Página inicial
          </q-tooltip>
        </q-route-tab>

        <q-route-tab name="reservations" icon="img:icons/booking.png" to="/reservations">
          <q-tooltip anchor="center right" self="center left" :offset="[10, 10]" class="text-subtitle2 bg-secondary">
            Reservas
          </q-tooltip>
        </q-route-tab>

        <q-route-tab name="menu" icon="img:icons/tray.png" to="/menu">
          <q-tooltip anchor="center right" self="center left" :offset="[10, 10]" class="text-subtitle2 bg-secondary">
            Menu
          </q-tooltip>
        </q-route-tab>
      </q-tabs>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const tab = ref('home');

</script>
