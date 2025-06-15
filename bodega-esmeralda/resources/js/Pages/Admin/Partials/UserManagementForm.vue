<template>
    <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
            <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full text-xs sm:text-base"
                v-model="form.name"
                required
                label="Name"
                label-class="text-xs sm:text-sm"
            />
            <InputError class="mt-2 text-xs sm:text-sm" :message="form.errors.name" />
        </div>

        <div>
            <TextInputSuffix
                id="email"
                type="email"
                class="mt-1 block w-full text-xs sm:text-base"
                v-model="form.email"
                required
                label="Email"
                label-class="text-xs sm:text-sm"
                suffix="@bodegas-esmeralda.ar"
            />
            <InputError class="mt-2 text-xs sm:text-sm" :message="form.errors.email" />
        </div>

        <div v-if="!isEdit">
            <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full text-xs sm:text-base"
                v-model="form.password"
                required
                label="Password"
                label-class="text-xs sm:text-sm"
                @input="validatePassword"
            />
            <div v-if="form.password" class="mt-1 text-xs text-gray-600">
                <p :class="{ 'text-red-500': !hasMinLength }">• At least 8 characters</p>
                <p :class="{ 'text-red-500': !hasUppercase }">• At least one uppercase letter</p>
                <p :class="{ 'text-red-500': !hasLowercase }">• At least one lowercase letter</p>
                <p :class="{ 'text-red-500': !hasNumber }">• At least one number</p>
                <p :class="{ 'text-red-500': !hasSpecialChar }">• At least one special character</p>
            </div>
            <InputError class="mt-2 text-xs sm:text-sm" :message="form.errors.password" />
        </div>

        <div v-if="!isEdit">
            <TextInput
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full text-xs sm:text-base"
                v-model="form.password_confirmation"
                required
                label="Confirm Password"
                label-class="text-xs sm:text-sm"
                @input="validatePassword"
            />

            <div v-if="form.password_confirmation && !passwordsMatch" class="mt-1 text-xs text-red-500">
                • Passwords do not match
            </div>

            <InputError class="mt-2 text-xs sm:text-sm" :message="form.errors.password_confirmation" />
        </div>

        <div>
            <SelectInput
                id="role"
                class="mt-1 block w-full text-xs sm:text-base"
                v-model="form.role"
                :options="[{ label: 'User', value: 'user' }, { label: 'Admin', value: 'admin' }]"
                label="Role"
                label-class="text-xs sm:text-sm"
            />
            <InputError class="mt-2 text-xs sm:text-sm" :message="form.errors.role" />
        </div>

        <div class="flex justify-end gap-x-3">
            <button
                v-if="isEdit"
                type="button"
                class="flex items-center justify-center h-12 w-auto rounded-md border border-gray-300 bg-white px-4 py-2 text-xs sm:text-base font-medium text-red-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                @click="handleCancel"
            >
                Cancel
            </button>
            <button
                type="submit"
                class="flex items-center justify-center h-12 w-auto rounded-md border border-transparent bg-primary-600 px-4 py-2 text-xs sm:text-base font-medium text-red-700 shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                :disabled="form.processing"
            >
                {{ submitLabel }}
            </button>
        </div>
    </form>
</template>

<script setup>
import TextInput from '@/Components/TextInput.vue';
import TextInputSuffix from '@/Components/TextInputSuffix.vue';
import SelectInput from '@/Components/SelectInput.vue';
import InputError from '@/Components/InputError.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    form: Object,
    isEdit: {
        type: Boolean,
        default: false
    },
    submitLabel: String,
});

const emit = defineEmits(['submit', 'cancel']);

const hasMinLength = computed(() => props.form.password?.length >= 8);
const hasUppercase = computed(() => /[A-Z]/.test(props.form.password || ''));
const hasLowercase = computed(() => /[a-z]/.test(props.form.password || ''));
const hasNumber = computed(() => /[0-9]/.test(props.form.password || ''));
const hasSpecialChar = computed(() => /[!@#$%^&*(),.?":{}|<>]/.test(props.form.password || ''));
const passwordsMatch = computed(() => props.form.password === props.form.password_confirmation);

const validatePassword = () => {
    // You can add additional validation logic here if needed
};

const handleSubmit = () => {
    emit('submit');
};

const handleCancel = () => {
    emit('cancel');
};
</script> 