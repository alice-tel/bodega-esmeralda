<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineProps({
    id: String,
    modelValue: String,
    type: {
        type: String,
        default: 'text',
    },
    label: String,
    required: Boolean,
    placeholder: {
        type: String,
        default: ' ',
    },
    autocomplete: String,
});

defineEmits(['update:modelValue']);

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative z-0 w-full group">
        <input
            :id="id"
            :type="type"
            class="block py-2.5 px-0 w-full text-sm text-font-100 bg-transparent border-t-0 border-l-0 border-r-0 border-b-2 border-gray-500 appearance-none focus:outline-none focus:ring-0 focus:border-details-100 peer"
            :placeholder="placeholder"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :autocomplete="autocomplete"
            :required="required"
        />
        <label
            v-if="label"
            :for="id"
            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-details-100"
        >
            {{ label }}
        </label>
    </div>
</template>
