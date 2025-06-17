<script setup>
import { useForm } from '@inertiajs/vue3';
import UserManagementForm from '@/Pages/Admin/Partials/UserManagementForm.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user'
});

const submit = () => {
    form.post(route('admin.users.store'), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-xs lg:text-xl font-medium text-font-900">Add New User</h2>
            <p class="mt-1 text-xs lg:text-sm  text-gray-600">
                Create a new user account.
            </p>
        </header>

        <UserManagementForm
            :form="form"
            submit-label="Add User"
            @submit="submit"
        />
    </section>
</template>
