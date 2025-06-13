<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import TextInputSuffix from "@/Components/TextInputSuffix.vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
        onSuccess: () => {
            localStorage.removeItem('welcomeShown');
            window.location.href = route('map');
        }
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit" class="max-w-xs mx-auto">
            <div>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    label="Name"
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <TextInputSuffix
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    label="Email"
                    required
                    autocomplete="username"
                    suffix="@bodegas-esmeralda.ar"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    label="Password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    label="Confirm Password"
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex flex-wrap justify-center items-center gap-x-3 gap-y-2">
                <PrimaryButton
                    class="w-auto px-3.5 h-10 flex items-center justify-center"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>

                <Link
                    :href="route('login')"
                    class="rounded-md text-sm px-3.5 py-2 font-medium text-gray-700 w-auto text-center h-10 flex items-center justify-center"
                >
                    Already registered?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
