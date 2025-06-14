<script setup>
import { useForm } from '@inertiajs/vue3';
import UserManagementForm from '@/Pages/Admin/Partials/UserManagementForm.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    cancelEdit: {
        type: Function,
        required: true
    }
});

const form = useForm({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    role: props.user.role
});

const submit = () => {
    form.put(route('admin.users.update', form.id), {
        onSuccess: () => {
            props.cancelEdit();
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-xs lg:text-xl  font-medium text-font-900">Edit User</h2>
            <p class="mt-1 text-xs lg:text-sm text-gray-600">
                Update selected user's information.
            </p>
        </header>

        <UserManagementForm
            :form="form"
            :isEdit="true"
            submit-label="Update User"
            @submit="submit"
            @cancel="cancelEdit"
        />
    </section>
</template> 