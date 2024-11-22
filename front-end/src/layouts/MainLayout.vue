<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense

          round
          aria-label="Menu"
          @click="toggleLeftDrawer"
        >
          <!-- change image on hover-->
          <q-img :src="!leftDrawerOpen ? 'icons/menu.png' : 'icons/menu-closed.png'" />
        </q-btn>

        <q-toolbar-title class="text-center">
          Reserva de restaurante
        </q-toolbar-title>

      </q-toolbar>
    </q-header>

    <q-drawer
      :mini="leftDrawerOpen"
      show-if-above
      class="animated"
      :width="150"
      :model-value="true"
    >
      <q-tabs
        vertical
        v-model="tab"
        class="bg-secondary"
        active-color="black"
        indicator-color="black"
        switch-indicator
      >
        <q-tab
          name="home"
          icon="img:icons/home.png"
          :label="leftDrawerOpen ? ' ' : 'Home'"
          to="/"
        />

        <q-tab
          name="reservations"
          icon="img:icons/booking.png"
          :label="leftDrawerOpen ? ' ' : 'Reservations'"
          to="/reservations"
        />

        <q-tab
          name="menu"
          icon="img:icons/restaurant.png"
          :label="leftDrawerOpen ? ' ' : 'Menu'"
          to="/menu"
        />
      </q-tabs>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const leftDrawerOpen = ref(false);
const tab = ref('home');

function toggleLeftDrawer () {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}
</script>
