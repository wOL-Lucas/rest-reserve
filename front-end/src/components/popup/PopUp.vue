<template>
  <q-dialog no-esc-dismiss no-backdrop-dismiss no-route-dismiss ref="dialogRef" @hide="onDialogHide">
    <q-card class="q-pa-xl popup-card" style="border-radius: 25px;">
      <q-icon>
        <q-icon :name="props.iconName" size="50px" color="secondary"/>
      </q-icon>
      <q-card-section class="text-h5 q-pa-md">
        {{ props.title }}
      </q-card-section>
      <q-card-section class="text-h6 q-pa-md">
        {{ props.description }}
      </q-card-section>
      <q-card-actions>
        <PrimaryButton label="OK" @click="onDialogHide" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script setup lang="ts">
import { useDialogPluginComponent } from 'quasar'
import PrimaryButton from '../button/PrimaryButton.vue'

const props = defineProps({
	title: { type: String, required: true },
	description: { type: String, required: true },
	iconName: { type: String, default: 'error' }
})

defineEmits([...useDialogPluginComponent.emits])

const { dialogRef, onDialogHide } = useDialogPluginComponent()

</script>
