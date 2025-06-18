<script setup>
import { onMounted, ref } from 'vue';
import {valueOrDefault} from "chart.js/helpers";

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

const { id, type, suffix } = defineProps({
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
    suffix: String,
});

function measureTextWidth(element){
    const c = document.createElement("canvas");
    const ctx = c.getContext("2d");
    ctx.font = font(element);
    return ctx.measureText(element.value+'A').width;
}

function font(element) {
    const prop = ["font-style", "font-variant", "font-weight", "font-size", "font-family"];
    let font = "";
    for (const x in prop)
        font += window.getComputedStyle(element, null).getPropertyValue(prop[x]) + " ";

    return font;
}

onMounted(() => {
    const input = document.getElementById(id);
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }


});

function focusOut(event){
    const input = event.target;
    if (input.value.length > 0) {
        input.value += suffix;
    }
    emit('update:modelValue', input.value)
    const bodegaLabel = input.parentElement.lastChild;
    bodegaLabel.hidden = true;
}
function focusIn(event){
    const input = event.target;
    input.value = withoutSuffix(input.value)
    const bodegaLabel = input.parentElement.lastChild;
    bodegaLabel.hidden = false;
}

function inputChanged(event) {
    const input = event.target;
    const textWidth = measureTextWidth(input)

    const suffixLabel = input.parentElement.lastChild;
    const suffixSize = suffixLabel.clientWidth;
    const totalLength = textWidth + suffixSize;
    suffixLabel.dataset.smaller = totalLength < input.clientWidth ? "false" : "true";
}

function withoutSuffix(value){
    return value.replace(suffix, '');
}


const emit = defineEmits(['update:modelValue']);

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative z-0 w-full group">
        <input
            :id="id"
            :type="type"
            class="block py-2.5 px-0 w-full text-s text-font-100 bg-transparent border-t-0 border-l-0 border-r-0 border-b-2 border-primary-100 appearance-none focus:outline-none focus:ring-0 focus:border-details-100 peer"
            :placeholder="placeholder"
            :value="modelValue"
            @input="inputChanged($event)"
            @focusin="focusIn($event)"
            @focusout="focusOut($event)"
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
        <label
            v-if="suffix"
            :for="id"
            hidden="hidden"
            data-smaller="false"
            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2.5 -z-10 right-0 origin-[0] data-[smaller=false]:scale-100 data-[smaller=false]:translate-y-0 data-[smaller=false]:right-2"
        >
            {{ suffix }}
        </label>
    </div>
</template>
