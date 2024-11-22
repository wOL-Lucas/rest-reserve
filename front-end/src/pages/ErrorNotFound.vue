<template>
  <div
    class="fullscreen text-white text-center q-pa-md flex flex-center"
    style="
      background-image: url('/rota_errada.jpg');
      background-repeat: no-repeat;
      background-size: contain;
      background-position: center;
      background-color: black;
      ">
    <div>
      <div style="font-size: 30vh">
        404
      </div>

      <div class="column text-h2 bg-black medium-border-radius">
        Rota errada, amigo.

      </div>
      <q-btn
      class="q-mt-xl"
      color="white"
      text-color="black"
      unelevated
      to="/"
      label="Quero voltaaaaaaaaar"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
defineOptions({
  name: 'ErrorNotFound'
});
</script>
