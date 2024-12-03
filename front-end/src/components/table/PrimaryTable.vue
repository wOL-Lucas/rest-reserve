<template>
  <q-page class="q-pa-md">
    <q-table ref="tableRef" @request="$emit('request', $event)" v-model:pagination="pagination"
      class="q-ma-md default-box-shadow" separator="horizontal" :rows="rows" :loading="loading" :columns="columns"
      row-key="id" no-results-label="Sem resultados" :filter="filter" rows-per-page-label="Linhas por página"
      loading-label="Carregando..." :pagination-label="getPaginationLabel" :rows-per-page-options="[10, 20, 30]"
      :visible-columns="props.visibleColumns || props.columns.map(column => column.name)">
      <template v-for="column in columns" :key="column.name" #[`header-cell-${column.name}`]="props">
        <slot :name="`header-cell-${column.name}`" :props="props">
          <q-th :align="column.align" :props="props">
            <span class="text-subtitle1"> {{ column.label }} </span>
          </q-th>
        </slot>
      </template>
      <template v-for="column in columns" :key="column.name" #[`body-cell-${column.name}`]="props">
        <slot :name="`body-cell-${column.name}`" :props="props">
          <q-td :align="column.align" :props="props">
            {{ typeof column.field === 'function' ? column.field(props.row) : props.row[column.name] }}
          </q-td>
        </slot>
      </template>
      <template #bottom-row>
        <slot name="bottom-row"></slot>
      </template>
      <template #loading>
        <q-inner-loading showing color="primary" />
      </template>
      <template #top-left>
        <slot name="top-left">
          <q-input outlined dense debounce="1000" v-model="filter" placeholder="Pesquisar...">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </slot>
      </template>
      <template #top-right>
        <slot name="top-right">
        </slot>
      </template>
      <template #no-data>
        <div class="text-h6 q-ma-md text-center full-width">Nenhum dado encontrado!</div>
      </template>
    </q-table>
  </q-page>
</template>

<script setup lang="ts">
import { QTable, QTableColumn } from 'quasar'
import { onMounted, ref, watch } from 'vue'

defineEmits(['request'])
const props = defineProps<{
  columns: QTableColumn[],
  rows: any,
  loading: boolean,
  refresh?: boolean,
  visibleColumns?: string[],
}>()

const pagination = defineModel('pagination') as any
const filter = ref('')
const tableRef = ref<QTable | null>(null)

const getPaginationLabel = (first: number, last: number, total: number) => `Exibindo ${first} a ${last} de ${total}`
onMounted(() => (tableRef.value) ? tableRef.value.requestServerInteraction() : null)
watch(() => props.refresh, () => tableRef.value ? tableRef.value.requestServerInteraction() : console.log('tableRef not defined'))
</script>
