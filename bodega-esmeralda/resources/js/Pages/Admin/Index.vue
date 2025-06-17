<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AddUserForm from '@/Pages/Admin/Partials/AddUserForm.vue';
import EditUserForm from '@/Pages/Admin/Partials/EditUserForm.vue';
import { emailDomain } from "@/app.js";

const props = defineProps({
    users: {
        type: Array,
        required: true
    }
});

const editingUser = ref(null);

const editUser = (user) => {
    editingUser.value = user;
};

const cancelEdit = () => {
    editingUser.value = null;
};

const deleteUser = (userId) => {
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete(route('admin.users.destroy', userId));
    }
};

const toggleRole = (user) => {
    router.put(route('admin.users.update', user.id), {
        role: user.role === 'admin' ? 'user' : 'admin'
    });
};
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Welcome, {{ $page.props.auth.user.name }}
        </template>

        <div class="py-3 min-h-[calc(100vh-16rem)]">
            <div class="mx-auto max-w-7xl space-y-4 px-2 sm:px-6 lg:px-8">
                <!-- Users Table Section -->
                <div class="overflow-hidden bg-background-100 shadow-sm rounded-lg">
                    <div class="p-3 sm:p-6">
                        <h3 class="text-xs lg:text-xl font-medium text-font-900 mb-4 sm:mb-6">User Management</h3>

                        <!-- Users Table -->
                        <div class="overflow-x-auto sm:mx-0">
                            <table class="min-w-full divide-y divide-primary-100">
                                <thead class="bg-background-100">
                                    <tr>
                                        <th scope="col" class="px-2 py-2 sm:px-6 sm:py-3.5 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Name
                                        </th>
                                        <th scope="col" class="px-2 py-2 sm:px-6 sm:py-3.5 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Email
                                        </th>
                                        <th scope="col" class="px-2 py-2 sm:px-6 sm:py-3.5 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Role
                                        </th>
                                        <th scope="col" class="px-2 py-2 sm:px-6 sm:py-3.5 text-center text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-primary-100 bg-background-100">
                                    <tr v-for="user in users" :key="user.id">
                                        <td class="whitespace-nowrap px-2 py-2 sm:px-6 sm:py-4 text-xs text-gray-900">
                                            {{ user.name }}
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 sm:px-6 sm:py-4 text-xs text-gray-900">
                                            {{ user.email }}
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 sm:px-6 sm:py-4 text-xs">
                                            <span
                                                :class="{
                                                    'bg-green-100 text-green-800': user.role === 'admin',
                                                    'bg-gray-100 text-gray-800': user.role === 'user'
                                                }"
                                                class="inline-flex rounded-full px-1.5 sm:px-2 text-[10px] sm:text-xs font-semibold leading-5"
                                            >
                                                {{ user.role }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 sm:px-6 sm:py-4 text-xs text-center">
                                            <div class="flex flex-col gap-1 sm:gap-2 sm:flex-row sm:gap-4 justify-center items-center">
                                                <button
                                                    @click="editUser(user)"
                                                    class="text-primary-600 hover:text-primary-900 text-[10px] sm:text-sm"
                                                >
                                                    Edit
                                                </button>
                                                <span v-if="user.role !== 'admin'" class="hidden sm:inline text-gray-300">|</span>
                                                <button
                                                    v-if="user.role !== 'admin'"
                                                    @click="toggleRole(user)"
                                                    class="text-primary-600 hover:text-primary-900 text-[10px] sm:text-sm"
                                                >
                                                    {{ user.role === 'admin' ? 'Make User' : 'Make Admin' }}
                                                </button>
                                                <span class="hidden sm:inline text-gray-300">|</span>
                                                <button
                                                    @click="deleteUser(user.id)"
                                                    class="text-red-600 hover:text-red-900 text-[10px] sm:text-sm"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Edit User Form Section -->
                <div v-if="editingUser" class="bg-background-100 p-3 shadow rounded-lg sm:p-8">
                    <EditUserForm
                        :user="editingUser"
                        :cancelEdit="cancelEdit"
                    />
                </div>

                <!-- Add User Form Section -->
                <div class="bg-background-100 p-3 shadow rounded-lg sm:p-8">
                    <AddUserForm />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
