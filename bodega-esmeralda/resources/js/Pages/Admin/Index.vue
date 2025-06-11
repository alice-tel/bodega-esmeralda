<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
    users: {
        type: Array,
        required: true
    }
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user'
});

const editForm = useForm({
    id: null,
    name: '',
    email: '',
    role: 'user'
});

const editingUser = ref(null);

const submit = () => {
    form.post(route('admin.users.store'), {
        onSuccess: () => {
            form.reset();
        },
    });
};

const editUser = (user) => {
    editingUser.value = user;
    editForm.id = user.id;
    editForm.name = user.name;
    editForm.email = user.email;
    editForm.role = user.role;
};

const updateUser = () => {
    editForm.put(route('admin.users.update', editForm.id), {
        onSuccess: () => {
            editingUser.value = null;
            editForm.reset();
        },
    });
};

const cancelEdit = () => {
    editingUser.value = null;
    editForm.reset();
};

const deleteUser = (userId) => {
    if (confirm('Are you sure you want to delete this user?')) {
        form.delete(route('admin.users.destroy', userId));
    }
};

const toggleRole = (user) => {
    form.put(route('admin.users.update', user.id), {
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

        <div class="py-12">
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
                <div v-if="editingUser" class="bg-white p-4 shadow rounded-lg sm:p-8 mb-6">
                    <h3 class="text-lg font-medium text-font-900 mb-6">Edit User</h3>
                    <form @submit.prevent="updateUser" class="space-y-4">
                        <div>
                            <TextInput
                                id="edit_name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="editForm.name"
                                required
                                label="Name"
                            />
                        </div>

                        <div>
                            <TextInput
                                id="edit_email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="editForm.email"
                                required
                                label="Email"
                            />
                        </div>

                        <div>
                            <SelectInput
                                id="edit_role"
                                class="mt-1 block w-full"
                                v-model="editForm.role"
                                :options="[{ label: 'User', value: 'user' }, { label: 'Admin', value: 'admin' }]"
                                label="Role"
                            />
                        </div>

                        <div class="flex justify-end gap-x-3">
                            <button
                                type="button"
                                class="flex items-center justify-center h-12 w-auto rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-red-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                                @click="cancelEdit"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="flex items-center justify-center h-12 w-auto rounded-md border border-transparent bg-primary-600 px-4 py-2 text-base font-medium text-red-700 shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                                :disabled="editForm.processing"
                            >
                                Update User
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Add User Form Section -->
                <div class="bg-white p-4 shadow rounded-lg sm:p-8">
                    <h3 class="text-lg font-medium text-font-900 mb-6">Add New User</h3>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                label="Name"
                            />
                        </div>

                        <div>
                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                label="Email"
                            />
                        </div>

                        <div>
                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                label="Password"
                            />
                        </div>

                        <div>
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password_confirmation"
                                required
                                label="Confirm Password"
                            />
                        </div>

                        <div>
                            <SelectInput
                                id="role"
                                class="mt-1 block w-full"
                                v-model="form.role"
                                :options="[{ label: 'User', value: 'user' }, { label: 'Admin', value: 'admin' }]"
                                label="Role"
                            />
                        </div>

                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="flex items-center justify-center h-12 w-auto rounded-md border border-transparent bg-primary-600 px-4 py-2 text-base font-medium text-red-700 shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                                :disabled="form.processing"
                            >
                                Add User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 