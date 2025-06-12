<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
        preserveScroll: true,
        onSuccess: () => {
            localStorage.removeItem('welcomeShown');
            const user = usePage().props.auth.user;
            if (user && user.role === 'admin') {
                window.location.href = route('admin.index');
            } else {
                window.location.href = route('dashboard');
            }
        }
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="max-w-xs mx-auto">
            <div>
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    label="Email"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    label="Password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600"
                        >Remember me</span
                    >
                </label>
            </div>

            <div class="mt-4 flex flex-wrap justify-center items-center gap-x-10 gap-y-2">
                <PrimaryButton
                    class="w-auto px-3.5 h-10 flex items-center justify-center text-white"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>

                <Link
                    :href="route('register')"
                    class="rounded-md text-sm bg-gray-100 px-3.5 py-2 font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 w-auto text-center h-10 flex items-center justify-center"
                >
                    Register
                </Link>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm px-3.5 py-2 font-medium text-gray-700 w-auto text-center h-10 flex items-center justify-center"
                >
                    Forgot your password?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
