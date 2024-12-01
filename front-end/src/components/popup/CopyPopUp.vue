<template>
  <q-dialog ref="dialogRef" @hide="onDialogHide" persistent no-backdrop-dismiss no-route-dismiss no-esc-dismiss>
    <q-card class="q-pa-xl popup-card">
      <q-icon>
        <q-icon name="error" size="50px" />
      </q-icon>
      <q-card-section class="text-h5 q-pa-md">
        {{ props.title }}
      </q-card-section>
      <q-card-section class="text-h6 q-pa-md">
        {{ props.description }}
      </q-card-section>
      <q-card-section class="full-width">
        <q-input outlined label="Link de pagamento" :model-value="props.stringToCopy" readonly>
          <template v-slot:prepend>
            <PrimaryButton flat icon="content_copy" @click="copyToClipboard(props.stringToCopy)">
              <q-tooltip class="text-subtitle2">Copiar</q-tooltip>
            </PrimaryButton>
          </template>
        </q-input>
      </q-card-section>
      <q-card-actions>
        <PrimaryButton rounded size="lg" label="OK" @click="onOKClick" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script setup lang="ts">
import { copyToClipboard, useDialogPluginComponent } from 'quasar'
import { useRouter } from 'vue-router'
import PrimaryButton from '../button/PrimaryButton.vue'

const props = defineProps({
	title: { type: String, required: true },
	description: { type: String, required: true },
	stringToCopy: { type: String, required: true },
	redirectTo: { type: String, default: '/home' }
})

defineEmits([
	...useDialogPluginComponent.emits
])

const { dialogRef, onDialogHide } = useDialogPluginComponent()

const router = useRouter()

function onOKClick () {
	if (dialogRef && dialogRef.value) dialogRef.value.hide()
	router.replace(props.redirectTo)
}

</script>
