<script setup>
    import { ref } from 'vue';
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import NavLink from '@/Components/NavLink.vue';
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
    import { Link } from '@inertiajs/vue3';
    import { Transition } from 'vue';

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
        <div class="min-h-screen bg-primary-100 flex flex-col">

            <nav class="border-b border-font-100 bg-primary-100">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto px-4 sm:px-8 lg:px-10">
                    <div class="flex h-16 justify-between">
                        <div class="flex">

                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <template v-if="$page.props.auth.user.role === 'admin'">
                                    <Link :href="route('admin.index')">
                                        <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800"/>
                                    </Link>
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
                                <div class="flex items-center space-x-4">
                                    <button
                                        @click="navigateToProfile"
                                        class="p-2 text-font-100 hover:text-details-100 transition duration-150 ease-in-out focus:outline-none"
                                        :class="{ 'text-gray-700': route().current('profile.edit') }"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </button>
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="p-2 text-font-100 hover:text-details-100 transition duration-150 ease-in-out focus:outline-none"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                        </svg>
                                    </Link>
                                </div>
                            </template>
                            <template v-else>
                                <!-- User Name and Navigation Links -->
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm font-medium text-font-100">
                                        {{ $page.props.auth.user.name }}
                                    </span>
                                    <button
                                        @click="navigateToProfile"
                                        class="p-2 text-font-100 hover:text-details-100 transition duration-150 ease-in-out focus:outline-none"
                                        :class="{ 'text-gray-700': route().current('profile.edit') }"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </button>
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="p-2 text-font-100 hover:text-details-100 transition duration-150 ease-in-out focus:outline-none"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                        </svg>
                                    </Link>
                                </div>
                            </template>
                        </div>

                        <!-- Mobile Navigation -->
                        <div class="-me-2 flex items-center space-x-2 sm:hidden">
                            <template v-if="$page.props.auth.user.role === 'admin'">
                                <button
                                    @click="navigateToAdmin"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-font-100 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 focus:outline-none"
                                    :class="{ 'text-gray-700': route().current('admin.index') }"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                                    </svg>
                                </button>
                                <button
                                    @click="navigateToProfile"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-font-100 hover:text-details-100 transition duration-150 ease-in-out focus:outline-none"
                                    :class="{ 'text-gray-700': route().current('profile.edit') }"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </button>
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-font-100 hover:text-details-100 transition duration-150 ease-in-out focus:outline-none"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                </Link>
                            </template>
                            <template v-else>
                                <button
                                    @click="navigateToDashboard"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-font-100 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 focus:outline-none"
                                    :class="{ 'text-gray-700': route().current('dashboard') }"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                    </svg>
                                </button>
                                <button
                                    @click="navigateToMap"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-font-100 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 focus:outline-none"
                                    :class="{ 'text-gray-700': route().current('map') }"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0zM16.5 15.75l-3.75-3.75" />
                                    </svg>
                                </button>
                                <button
                                    @click="navigateToProfile"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-font-100 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 focus:outline-none"
                                    :class="{ 'text-gray-700': route().current('profile.edit') }"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </button>
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-font-100 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 focus:outline-none"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <Transition
                    enter-active-class="transition-all duration-300 ease-out"
                    enter-from-class="opacity-0 -translate-y-1"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition-all duration-500 ease-in-out"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-1"
                >
                    <div
                        v-show="showingNavigationDropdown"
                        class="fixed inset-x-0 top-16 z-50 bg-primary-100 border-b border-font-100"
                    >
                        <div class="px-4 py-2">
                            <div class="flex flex-col items-center space-y-3">
                                <span class="text-lg font-bold text-font-100">
                                    {{ $page.props.auth.user.name }}
                                </span>
                                <div class="flex items-center space-x-4">
                                    <template v-if="$page.props.auth.user.role === 'admin'">
                                        <ResponsiveNavLink
                                            @click="navigateToAdmin"
                                            :active="route().current('admin.index')"
                                        >
                                            Admin
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
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </Transition>
            </nav>

            <!-- Page Heading -->
            <header class="bg-primary-100 shadow transition-all duration-300" v-if="$slots.header">
                <div class="mx-auto px-4 py-2 pt-3 sm:px-8 sm:py-4 md:px-10 md:py-5 lg:px-10 lg:py-6">
                    <h2 class="text-lg sm:text-xl font-semibold leading-tight text-font-800">
                        <slot name="header"/>
                    </h2>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 transition-all duration-300">
                <slot/>
            </main>

            <!-- Footer -->
            <footer class="bg-primary-100">
                <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex justify-center items-center text-xs sm:text-sm text-font-600">
                        © {{ new Date().getFullYear() }} Bodegas Esmelralda - All rights reserved.
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>
