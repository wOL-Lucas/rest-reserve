<template>
  <div class="row items-center justify-center text-center" style="height: 100vh;">
    <div class="half-width q-pa-lg default-box-shadow big-border-radius">
      <div class="flex-grow">
        <q-img style="width: 100px;" fit="fill" src="/icons/restaurant.png" class="q-mb-md" />
        <div class="text-h4">Reserva de restaurante</div>
        <q-form ref="myForm" @submit="submit">
          <div>
            <q-input :error="invalidCredentials" outlined no-error-icon class="q-mb-md" v-model="email" label="E-mail"
              autocomplete="username"
              :rules="[(val: any) => Validator.isValidEmail(val) || 'Por favor, insira um e-mail válido']" lazy-rules />
            <q-input :error="invalidCredentials" outlined no-error-icon class="login__form__input q-mb-md"
              v-model="password" label="Senha" :type="isPwd ? 'password' : 'text'" autocomplete="current-password"
              :rules="[(val: any) => Validator.isValidPassword(val) || 'Por favor, insira uma senha válida']"
              lazy-rules>
              <template v-slot:append>
                <q-icon :name="isPwd ? 'visibility_off' : 'visibility'" class="cursor-pointer" @click="isPwd = !isPwd"
                  color="primary" />
              </template>
            </q-input>
            <div class="row q-mb-md justify-between">
              <q-checkbox dense v-model="rememberMe" label="Lembrar e-mail" color="primary" size="xs" />
            </div>
          </div>
          <PrimaryButton :loading="loading" label="Entrar" :btn-type="'submit'" rounded class="full-width" />
          <div class="q-mt-xl">Foi convidado?</div>
          <PrimaryButton @click="router.push('/auth/signup')" label="Cadastre-se" :btn-type="'button'" outlined
            size="sm" />
        </q-form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import PrimaryButton from 'src/components/button/PrimaryButton.vue'
import { AxiosHttp } from 'src/http/axios';
import HttpRequest from 'src/http/httpRequest';
import { NotifyError } from '../../utils/utils';
import { Validator } from '../../utils/validator';

const email = ref('')
const password = ref('')
const isPwd = ref(true)
const loading = ref(false)
const rememberMe = ref(false)
const router = useRouter()
const invalidCredentials = ref(false)
const http = new AxiosHttp()

onMounted(() => {
  email.value = atob(localStorage.getItem('email') || '')
  email.value ? rememberMe.value = true : rememberMe.value = false
})

const submit = async () => {
  loading.value = true
  await http.post(
    new HttpRequest('/login', { email: email.value, password: password.value }))
    .then((response: any) => {
      rememberMe.value
        ? localStorage.setItem('email', btoa(email.value))
        : localStorage.removeItem('email')
      localStorage.setItem('accessToken', response.token)
      router.push('/')
    })
    .catch((error: any) => {
      console.log(error)
      NotifyError.error(error.message)
    })
    .finally(() => {
      loading.value = false
      setTimeout(() => {
        invalidCredentials.value = false
      }, 6000)
    })
}
</script>
