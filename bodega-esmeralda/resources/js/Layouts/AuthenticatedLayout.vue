<script setup>
    import { ref } from 'vue';
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
    import NavLink from '@/Components/NavLink.vue';
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
    import { Link, router } from '@inertiajs/vue3';

    const showingNavigationDropdown = ref(false);

    const navigateToProfile = () => {
        window.location.href = route('profile.edit');
    };

    const navigateToDashboard = () => {
        window.location.href = route('dashboard');
    };

    const navigateToMap = () => {
        window.location.href = route('map');
    };

    const navigateToAdmin = () => {
        window.location.href = route('admin.index');
    };
</script>

<template>
    <div>
        <div class="min-h-screen bg-primary-100">

            <nav class="border-b border-font-100 bg-primary-100">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">

                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <template v-if="$page.props.auth.user.role === 'admin'">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800"/>
                                </template>
                                <template v-else>
                                    <Link :href="route('dashboard')">
                                        <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800"/>
                                    </Link>
                                </template>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <template v-if="$page.props.auth.user.role === 'admin'">
                                    <NavLink 
                                        @click="navigateToAdmin" 
                                        :active="route().current('admin.index')"
                                    >
                                        Admin
                                    </NavLink>
                                </template>
                                <template v-else>
                                    <NavLink 
                                        @click="navigateToDashboard" 
                                        :active="route().current('dashboard')"
                                    >
                                        Dashboard
                                    </NavLink>
                                    <NavLink 
                                        @click="navigateToMap" 
                                        :active="route().current('map')"
                                    >
                                        Map
                                    </NavLink>
                                </template>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <template v-if="$page.props.auth.user.role === 'admin'">
                                <div class="flex space-x-8 sm:-my-px sm:ms-10">
                                    <NavLink 
                                        @click="navigateToProfile"
                                        :active="route().current('profile.edit')"
                                    >
                                        Profile
                                    </NavLink>
                                    <NavLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                    >
                                        Log Out
                                    </NavLink>
                                </div>
                            </template>
                            <template v-else>
                                <!-- Settings Dropdown -->
                                <div class="relative ms-3">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center rounded-md border-transparent bg-primary-100 px-3 py-2 text-sm font-medium leading-4 text-font-100 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                                >
                                                    {{ $page.props.auth.user.name }}

                                                    <svg
                                                        class="-me-0.5 ms-2 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <DropdownLink
                                                @click="navigateToProfile"
                                            >
                                                Profile
                                            </DropdownLink>

                                            <DropdownLink
                                                :href="route('logout')"
                                                method="post"
                                                as="button"
                                            >
                                                Log Out
                                            </DropdownLink>
                                            
                                        </template>
                                    </Dropdown>
                                </div>
                            </template>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center rounded-md p-2 text-red-500 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-red-600 focus:bg-gray-100 focus:text-red-600 focus:outline-none">

                                <svg class="h-6 w-6 details-100" stroke="currentColor" fill="none"  viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <div class="px-4">
                            <div class="text-lg font-bold text-font-100 -ml-1">
                                {{ $page.props.auth.user.name }}
                            </div>
                        </div>
                        <template v-if="$page.props.auth.user.role === 'admin'">
                            <ResponsiveNavLink
                                @click="navigateToAdmin"
                                :active="route().current('admin.index')"
                            >
                                Admin Dashbaord
                            </ResponsiveNavLink>
                            <ResponsiveNavLink 
                                @click="navigateToProfile"
                                :active="route().current('profile.edit')"
                            >
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </template>
                        <template v-else>
                            <ResponsiveNavLink
                                @click="navigateToDashboard"
                                :active="route().current('dashboard')"
                            >
                                Dashboard
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                @click="navigateToMap"
                                :active="route().current('map')"
                            >
                                Map
                            </ResponsiveNavLink>
                            <ResponsiveNavLink 
                                @click="navigateToProfile"
                                :active="route().current('profile.edit')"
                            >
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </template>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-primary-100 shadow" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>
