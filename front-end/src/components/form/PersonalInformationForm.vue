<template>
  <q-card class="big-border-radius default-box-shadow q-pa-md">
    <q-card-section class="q-gutter-y-md">
      <q-form ref="personalInformationForm" @submit="$emit('submit')">
        <q-input v-if="withName" v-model.trim="customer.firstName" label="Nome" lazy-rules pattern="[a-zA-Z ]*"
          :rules="[(val: string) => Validator.isValidName(val) || 'Campo obrigatório']">
          <template v-slot:prepend>
            <q-icon name="person" />
          </template>
        </q-input>
        <q-input v-if="withName" v-model.trim="customer.lastName" label="Sobrenome" lazy-rules pattern="[a-zA-Z ]*"
          :rules="[(val: string) => Validator.isValidName(val) || 'Campo obrigatório']">
          <template v-slot:prepend>
            <q-icon name="person" />
          </template>
        </q-input>
        <q-input v-model="customer.document" label="Documento"
          :rules="[(val: string) => Validator.isValidCPF(val) || 'CPF inválido']" mask="###.###.###-##" lazy-rules>
          <template v-slot:prepend>
            <q-icon name="wallet" />
          </template>
        </q-input>
        <q-select v-model="customer.role" label="Tipo de usuário" :rules="[(val: string) => !!val || 'Tipo inválido']"
          lazy-rules emit-value map-options :options="userTypeOptions" />
        <q-input v-model.trim="customer.email" label="E-mail"
          :rules="[(val: string) => Validator.isValidEmail(val) || 'E-mail inválido']" lazy-rules>
          <template v-slot:prepend>
            <q-icon name="email" />
          </template>
        </q-input>
        <q-input v-model="customer.password" label="Senha" no-error-icon
          :rules="[(val) => Validator.isValidPassword(val) || 'Por favor, insira uma senha válida']" lazy-rules
          :type="showPassword ? 'text' : 'password'">
          <template v-slot:append>
            <q-icon :name="showPassword ? 'visibility_off' : 'visibility'" class="cursor-pointer"
              @click="showPassword = !showPassword" />
          </template>
        </q-input>
      </q-form>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import { emit } from 'process';
import { QForm } from 'quasar';
import { Customer } from 'src/models/customer';
import { Validator } from 'src/utils/validator'
import { defineModel, ref, watch } from 'vue'

const personalInformationForm = ref<any>(null)
const showPassword = ref(false)
const customer = defineModel('customer', {
  type: Customer,
  default: () => new Customer()
})

const userTypeOptions = [
  { label: 'Cliente', value: 'user' },
  { label: 'Gerente de restaurante', value: 'manager' },
]

defineEmits(['submit'])
const props = defineProps({
  withName: {
    type: Boolean,
    default: true
  },
  submit: {
    type: Boolean,
    default: false
  }
})

watch(() => props.submit, async () => {
  if (personalInformationForm.value) {
    if (await (personalInformationForm.value as QForm).validate()) {
      (personalInformationForm.value as QForm).submit()
    }
  }
})

</script>
