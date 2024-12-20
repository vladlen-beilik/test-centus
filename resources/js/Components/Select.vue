<script setup>
import { ref } from 'vue';

defineProps({
    modelValue: [String, Number],
    options: {
        type: Array,
        default: () => [],
    }
});

defineEmits(['update:modelValue']);

const select = ref(null);

</script>

<template>
    <select
        ref="select"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm disabled:bg-gray-100"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
    >
        <option v-for="option in options" :value="option.id" :key="option.id">{{ option.name }}</option>
    </select>
</template>
