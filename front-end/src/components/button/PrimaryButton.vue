<template>
    <q-btn
		:fab="fab"
        no-wrap
        :loading="loading"
        :size="size"
        :label="label"
        :rounded="rounded"
        :color="disabled ? 'grey' : 'primary'"
        :type="btnType"
        :outline="outlined"
		:flat="flat"
        @click="$emit('click')"
		:disable="disabled"
		:icon="icon"
		:icon-right="iconRight"
		:no-caps="noCaps"
		:to="to"
		:dense="dense"
		>
		<slot></slot>
	</q-btn>
</template>

<script setup lang="ts">
defineProps({
	btnType: {
		type: String,
		default: 'button'
	},
	size: {
		type: String,
		default: 'md'
	},
	label: String,
	rounded: Boolean,
	loading: Boolean,
	outlined: Boolean,
	flat: Boolean,
	disabled: Boolean,
	icon: String,
	iconRight: String,
	noCaps: Boolean,
	to: String,
	dense: Boolean,
	fab: Boolean
})

defineEmits(['click'])
</script>
