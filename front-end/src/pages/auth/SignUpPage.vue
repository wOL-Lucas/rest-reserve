<template>
  <div class="column flex-center q-gutter-y-md">
    <div class="row flex-start half-width">
      <PrimaryButton icon="arrow_back" rounded @click="router.back" />
    </div>
    <PersonalInformationForm class="half-width" :submit="submit" v-model:customer="customer" with-name
      @submit="submitForm" />
    <PrimaryButton label="Enviar" :loading="loading" @click="submit = !submit" />
  </div>
</template>

<script setup lang="ts">
import PrimaryButton from 'src/components/button/PrimaryButton.vue';
import PersonalInformationForm from 'src/components/form/PersonalInformationForm.vue';
import { AxiosHttp } from 'src/http/axios';
import HttpRequest from 'src/http/httpRequest';
import { Customer } from 'src/models/customer';
import { NotifyError, ShowDialog } from 'src/utils/utils';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const customer = ref(new Customer());
const submit = ref(false);
const loading = ref(false);
const router = useRouter();
const http = new AxiosHttp();

const submitForm = async () => {
  loading.value = true;
  await http.post(
    new HttpRequest('/users', customer.value.toJson()))
    .then(() => {
      ShowDialog.show('Sucesso', 'Usuário cadastrado com sucesso!', 'img:/icons/verifica.png');
      router.push('/auth/login')
    })
    .catch((error: any) => {
      NotifyError.error(error.message)
    })
    .finally(() => { loading.value = false })
};
</script>
