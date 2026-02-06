<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';
import Modal from '@/Components/Modal.vue';
import ChangePasswordForm from '@/Components/ChangePasswordForm.vue';

const page = usePage();

const auth = computed(() => page.props.auth || { user: null });
const config = computed(() => page.props.config || {});
const flash = computed(() => page.props.flash || {});

const showMobileMenu = ref(false);

const toggleMobileMenu = () => {
    showMobileMenu.value = !showMobileMenu.value;
};

</script>

<template>
    <div class="min-h-screen flex flex-col bg-gray-900">
        <!-- Header with Navigation -->
        <header class="bg-slate-900/95 border-b border-slate-800 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Left: Logo and Nav -->
                    <div class="flex items-center gap-6">
                        <Link href="/" class="flex items-center gap-3">
                            <img
                                src="/img/logo_default.png"
                                alt="Logo"
                                class="h-8 w-auto"
                                onerror="this.style.display='none'"
                            />
                            <h1 class="text-xl font-bold text-slate-100">
                                {{ config.appName }}
                            </h1>
                        </Link>
                        <nav class="hidden md:flex items-center gap-1">
                            <Link
                                href="/"
                                class="px-3 py-1.5 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors"
                            >
                                Rota
                            </Link>
                            <a
                                v-if="auth.user?.is_admin"
                                href="/admin"
                                class="px-3 py-1.5 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors"
                            >
                                Admin
                            </a>
                        </nav>
                    </div>

                    <!-- Right nav items - Desktop -->
                    <div class="hidden md:flex items-center gap-2">
                        <template v-if="auth.user">
                            <Link
                                href="/change-password"
                                class="px-3 py-1.5 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors"
                            >
                                Change Password
                            </Link>
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                type="button"
                                class="px-3 py-1.5 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors"
                            >
                                Logout
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                href="/login"
                                class="px-3 py-1.5 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors"
                            >
                                Login
                            </Link>
                            <Link
                                v-if="config.registerEnabled"
                                href="/register"
                                class="btn btn-primary text-sm px-4 py-1.5"
                            >
                                Register
                            </Link>
                        </template>
                    </div>

                    <!-- Mobile menu button -->
                    <button
                        @click="toggleMobileMenu"
                        class="md:hidden p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-800/60 transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                v-if="!showMobileMenu"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                v-else
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Mobile menu -->
                <div v-if="showMobileMenu" class="md:hidden py-2 border-t border-slate-800 space-y-1">
                    <Link
                        href="/"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                        @click="showMobileMenu = false"
                    >
                        Rota
                    </Link>
                    <a
                        v-if="auth.user?.is_admin"
                        href="/admin"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                    >
                        Admin
                    </a>
                    <template v-if="auth.user">
                        <Link
                            href="/change-password"
                            class="block px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                            @click="showMobileMenu = false"
                        >
                            Change Password
                        </Link>
                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            type="button"
                            class="block w-full text-left px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                            @click="showMobileMenu = false"
                        >
                            Logout
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            href="/login"
                            class="block px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                            @click="showMobileMenu = false"
                        >
                            Login
                        </Link>
                        <Link
                            v-if="config.registerEnabled"
                            href="/register"
                            class="block px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                            @click="showMobileMenu = false"
                        >
                            Register
                        </Link>
                    </template>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <Toast
            v-if="flash.message"
            :message="flash.message"
            type="success"
        />
        <Toast
            v-if="flash.error"
            :message="flash.error"
            type="error"
        />

        <!-- Main Content -->
        <main class="flex-1 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900/95 border-t border-slate-800 py-3">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <span class="text-slate-400 text-sm">
                        <template v-if="auth.user">
                            {{ auth.user.name }}
                        </template>
                        <template v-else>
                            Logged Out
                        </template>
                    </span>
                    <span v-if="config.footerText" class="text-slate-500 text-xs">
                        {{ config.footerText }}
                    </span>
                </div>
            </div>
        </footer>

    </div>
</template>
