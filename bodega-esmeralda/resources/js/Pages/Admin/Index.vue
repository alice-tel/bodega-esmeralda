<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AddUserForm from '@/Pages/Admin/Partials/AddUserForm.vue';
import EditUserForm from '@/Pages/Admin/Partials/EditUserForm.vue';

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
            <h2 class="text-xl font-semibold leading-tight text-font-800">
                Admin Dashboard
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
                <!-- Users Table Section -->
                <div class="overflow-hidden bg-background-100 shadow-sm rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg font-medium text-font-900 mb-6">User Management</h3>

                        <!-- Users Table -->
                        <div class="overflow-x-auto -mx-4 sm:mx-0">
                            <table class="min-w-full divide-y divide-primary-100">
                                <thead class="bg-background-100">
                                    <tr>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6">
                                            Name
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6">
                                            Email
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6">
                                            Role
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-center text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-primary-100 bg-background-100">
                                    <tr v-for="user in users" :key="user.id">
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 sm:px-6">
                                            {{ user.name }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 sm:px-6">
                                            {{ user.email }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm sm:px-6">
                                            <span
                                                :class="{
                                                    'bg-green-100 text-green-800': user.role === 'admin',
                                                    'bg-gray-100 text-gray-800': user.role === 'user'
                                                }"
                                                class="inline-flex rounded-full px-2 text-xs font-semibold leading-5"
                                            >
                                                {{ user.role }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm sm:px-6 text-center">
                                            <div class="flex flex-col gap-2 sm:flex-row sm:gap-4 justify-center items-center">
                                                <button
                                                    @click="editUser(user)"
                                                    class="text-primary-600 hover:text-primary-900"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    v-if="user.role !== 'admin'"
                                                    @click="toggleRole(user)"
                                                    class="text-primary-600 hover:text-primary-900"
                                                >
                                                    {{ user.role === 'admin' ? 'Make User' : 'Make Admin' }}
                                                </button>
                                                <button
                                                    @click="deleteUser(user.id)"
                                                    class="text-red-600 hover:text-red-900"
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
                <div v-if="editingUser" class="bg-background-100 p-4 shadow rounded-lg sm:p-8 mb-6">
                    <EditUserForm
                        :user="editingUser"
                        :cancelEdit="cancelEdit"
                    />
                </div>

                <!-- Add User Form Section -->
                <div class="bg-background-100 p-4 shadow rounded-lg sm:p-8">
                    <AddUserForm />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 