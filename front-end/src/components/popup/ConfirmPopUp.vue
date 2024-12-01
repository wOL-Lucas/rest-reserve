<template>
    <q-dialog ref="dialogRef"
    @hide="onDialogHide"
    no-backdrop-dismiss
    no-esc-dismiss
    no-route-dismiss
    >
      <q-card class="q-pa-xl popup-card" style="border-radius: 25px;">
        <q-card-section>
            <q-icon name="error" size="50px" :color="color" />
            <h4>{{ title }}</h4>
            <h6>{{ message }}</h6>
        </q-card-section>

        <q-card-actions>
          <q-btn :color="color" label="Voltar" @click="onDialogCancel" />
          <q-btn flat :color="color" label="Continuar" @click="onDialogOK" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </template>

<script setup>
import { useDialogPluginComponent } from 'quasar'

defineProps({
	title: { type: String, required: true },
	message: { type: String, required: true },
	color: { type: String, default: 'secondary' }
})

defineEmits([
	// REQUIRED; need to specify some events that your
	// component will emit through useDialogPluginComponent()
	...useDialogPluginComponent.emits
])

const { dialogRef, onDialogHide, onDialogOK, onDialogCancel } = useDialogPluginComponent()
// dialogRef      - Vue ref to be applied to QDialog
// onDialogHide   - Function to be used as handler for @hide on QDialog
// onDialogOK     - Function to call to settle dialog with "ok" outcome
//                    example: onDialogOK() - no payload
//                    example: onDialogOK({ /*...*/ }) - with payload
// onDialogCancel - Function to call to settle dialog with "cancel" outcome
</script>
