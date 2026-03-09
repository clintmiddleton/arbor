<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';
import { Button } from '@/Components/ui/button';
import { Link } from '@inertiajs/vue3';
import { ChevronDown } from 'lucide-vue-next';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="border-b border-gray-100 bg-white">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <!-- Left: Logo + nav items -->
                        <div class="flex items-center gap-6">
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo />
                                </Link>
                            </div>
                            <div
                                class="hidden sm:flex sm:items-center sm:gap-2"
                            >
                                <Button variant="ghost" asChild>
                                    <Link
                                        :href="route('dashboard')"
                                        :class="
                                            route().current('dashboard')
                                                ? 'bg-accent text-accent-foreground'
                                                : ''
                                        "
                                    >
                                        Dashboard
                                    </Link>
                                </Button>
                                <Button
                                    v-if="$page.props.auth.can?.accessAdmin"
                                    variant="ghost"
                                    asChild
                                >
                                    <Link
                                        :href="route('admin.users.index')"
                                        :class="
                                            route().current('admin.users.*')
                                                ? 'bg-accent text-accent-foreground'
                                                : ''
                                        "
                                    >
                                        Admin
                                    </Link>
                                </Button>
                            </div>
                        </div>

                        <!-- Right: user menu + future items -->
                        <div class="flex items-center gap-2">
                            <div
                                class="hidden sm:flex sm:items-center sm:gap-2"
                            >
                                <DropdownMenu>
                                    <DropdownMenuTrigger asChild>
                                        <Button variant="ghost">
                                            {{ $page.props.auth.user.name }}
                                            <ChevronDown class="h-4 w-4" />
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent
                                        align="end"
                                        class="min-w-[200px]"
                                    >
                                        <DropdownMenuItem asChild>
                                            <Link
                                                :href="route('profile.edit')"
                                                class="cursor-pointer"
                                            >
                                                Profile
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem asChild>
                                            <Link
                                                :href="route('logout')"
                                                method="post"
                                                as="button"
                                                class="cursor-pointer"
                                            >
                                                Log Out
                                            </Link>
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                                <!-- Add more right nav items here -->
                            </div>

                            <!-- Hamburger -->
                            <div class="-me-2 flex items-center sm:hidden">
                                <button
                                    @click="
                                        showingNavigationDropdown =
                                            !showingNavigationDropdown
                                    "
                                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                                >
                                    <svg
                                        class="h-6 w-6"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
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
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pt-2 pb-3">
                        <Link
                            :href="route('dashboard')"
                            :class="
                                route().current('dashboard')
                                    ? 'border-primary text-primary bg-primary/10 block w-full border-l-4 py-2 ps-3 pe-4 text-start text-base font-medium'
                                    : 'block w-full border-l-4 border-transparent py-2 ps-3 pe-4 text-start text-base font-medium text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800'
                            "
                        >
                            Dashboard
                        </Link>
                        <Link
                            v-if="$page.props.auth.can?.accessAdmin"
                            :href="route('admin.users.index')"
                            :class="
                                route().current('admin.users.*')
                                    ? 'border-primary text-primary bg-primary/10 block w-full border-l-4 py-2 ps-3 pe-4 text-start text-base font-medium'
                                    : 'block w-full border-l-4 border-transparent py-2 ps-3 pe-4 text-start text-base font-medium text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800'
                            "
                        >
                            Admin
                        </Link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="border-t border-gray-200 pt-4 pb-1">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <Link
                                :href="route('profile.edit')"
                                :class="
                                    route().current('profile.edit')
                                        ? 'border-primary text-primary bg-primary/10 block w-full border-l-4 py-2 ps-3 pe-4 text-start text-base font-medium'
                                        : 'block w-full border-l-4 border-transparent py-2 ps-3 pe-4 text-start text-base font-medium text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800'
                                "
                            >
                                Profile
                            </Link>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="block w-full border-l-4 border-transparent py-2 ps-3 pe-4 text-start text-base font-medium text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800"
                            >
                                Log Out
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
