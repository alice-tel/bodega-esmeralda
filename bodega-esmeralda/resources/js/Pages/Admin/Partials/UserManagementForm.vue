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
            <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full text-xs sm:text-base"
                v-model="form.email"
                required
                label="Email"
                label-class="text-xs sm:text-sm"
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
            />
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
            />
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
import SelectInput from '@/Components/SelectInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    form: Object,
    isEdit: {
        type: Boolean,
        default: false
    },
    submitLabel: String,
});

const emit = defineEmits(['submit', 'cancel']);

const handleSubmit = () => {
    emit('submit');
};

const handleCancel = () => {
    emit('cancel');
};
</script> 