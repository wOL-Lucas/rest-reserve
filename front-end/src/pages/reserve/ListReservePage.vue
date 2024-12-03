<template>
  <q-page class="q-pa-md">
    <PrimaryTable :columns="columns" :rows="rows" :loading="loading" :pagination="pagination" />
  </q-page>
</template>

<script setup lang="ts">
import { QTableColumn } from 'quasar';
import PrimaryTable from 'src/components/table/PrimaryTable.vue';
import { Reserve } from 'src/models/reserve';
import { useReserveStore } from 'src/stores/reserveStore';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router'

const router = useRouter()
const loading = ref(false)
const rows = ref([] as Reserve[])
const pagination = ref({ sortBy: 'id', descending: false, page: 1, rowsPerPage: 10 })
const reserveStore = useReserveStore()

const columns: QTableColumn[] = [
  { name: 'id', label: 'ID', align: 'center', field: (row: any) => row.id },
  { name: 'name', label: 'Nome', align: 'left', field: (row: any) => row.name },
  { name: 'email', label: 'E-mail', align: 'left', field: (row: any) => row.email },
  { name: 'phone', label: 'Telefone', align: 'center', field: (row: any) => row.phone },
  { name: 'date', label: 'Data', align: 'center', field: (row: any) => row.date },
  { name: 'hour', label: 'Hora', align: 'center', field: (row: any) => row.hour },
  {
    name: 'actions', label: 'Ações', align: 'center', field: (row: any) => {
      return [
        { icon: 'edit', label: 'Editar', action: () => router.push(`/reserve/edit/${row.id}`) },
        { icon: 'delete', label: 'Excluir', action: () => router.push(`/reserve/delete/${row.id}`) },
      ]
    }
  },
]

onMounted(async () => {
  loading.value = true
  await reserveStore.fetchReserves()
  rows.value = reserveStore.reserves
  loading.value = false
})
</script>
