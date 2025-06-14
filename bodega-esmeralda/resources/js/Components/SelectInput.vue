<script setup>
import { computed, ref, onMounted } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        required: true,
    },
    label: {
        type: String,
        default: '',
    },
    options: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(['update:modelValue']);

const select = ref(null);

const isFocused = ref(false);

const showPlaceholder = computed(
    () => !props.modelValue && !isFocused.value
);

const onFocus = () => {
    isFocused.value = true;
};

const onBlur = () => {
    isFocused.value = false;
};

onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        select.value.focus();
    }
});

const classes = [
    'block w-full py-2.5 px-3 text-xs sm:text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-primary-600 peer',
    'shadow-sm',
];
</script>

<template>
    <div class="relative">
        <label
            v-if="label"
            :class="{
                'absolute text-xs sm:text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-primary-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1': true,
                '-translate-y-4 scale-75 top-2': modelValue || isFocused
            }"
        >
            {{ label }}
        </label>
        <select
            :value="modelValue"
            @input="emit('update:modelValue', $event.target.value)"
            @focus="onFocus"
            @blur="onBlur"
            ref="select"
            :class="classes"
        >
            <option v-for="option in options" :key="option.value" :value="option.value">
                {{ option.label }}
            </option>
        </select>
    </div>
</template> 