<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems, TransitionRoot, TransitionChild } from '@headlessui/vue';
import Toast from '@/Components/Toast.vue';

const page = usePage();

const auth = computed(() => page.props.auth || { user: null });
const config = computed(() => page.props.config || {});
const flash = computed(() => page.props.flash || {});
</script>

<template>
    <div class="min-h-screen flex flex-col bg-slate-950">
        <header class="bg-slate-900/95 border-b border-slate-800 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <Disclosure v-slot="{ open, close }">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center gap-6">
                            <Link href="/" class="flex items-center gap-3">
                                <h1 class="text-xl font-bold text-slate-100">
                                    {{ config.appName }}
                                </h1>
                            </Link>
                            <nav class="hidden md:flex items-center gap-1">
                                <Link
                                    href="/"
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors"
                                >
                                    Dashboard
                                </Link>
                                <a
                                    v-if="auth.user?.is_admin"
                                    href="/admin"
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors"
                                >
                                    Admin
                                </a>
                            </nav>
                        </div>

                        <div class="hidden md:flex items-center gap-2">
                            <template v-if="auth.user">
                                <Menu as="div" class="relative">
                                    <MenuButton class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors">
                                        {{ auth.user.name }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </MenuButton>

                                    <TransitionRoot
                                        enter="transition ease-out duration-100"
                                        enter-from="transform opacity-0 scale-95"
                                        enter-to="transform opacity-100 scale-100"
                                        leave="transition ease-in duration-75"
                                        leave-from="transform opacity-100 scale-100"
                                        leave-to="transform opacity-0 scale-95"
                                    >
                                        <MenuItems class="absolute right-0 mt-2 w-48 origin-top-right rounded-xl bg-slate-800 border border-slate-700/50 shadow-lg focus:outline-none py-1">
                                            <MenuItem v-slot="{ active }">
                                                <Link
                                                    href="/change-password"
                                                    :class="[active ? 'bg-slate-700/50 text-white' : 'text-slate-300', 'block px-4 py-2 text-sm']"
                                                >
                                                    Change Password
                                                </Link>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }">
                                                <Link
                                                    href="/logout"
                                                    method="post"
                                                    as="button"
                                                    type="button"
                                                    :class="[active ? 'bg-slate-700/50 text-white' : 'text-slate-300', 'block w-full text-left px-4 py-2 text-sm']"
                                                >
                                                    Logout
                                                </Link>
                                            </MenuItem>
                                        </MenuItems>
                                    </TransitionRoot>
                                </Menu>
                            </template>
                            <template v-else>
                                <Link
                                    href="/login"
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors"
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

                        <DisclosureButton class="md:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/60 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    v-if="!open"
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
                        </DisclosureButton>
                    </div>

                    <DisclosurePanel class="md:hidden py-2 border-t border-slate-800 space-y-1">
                        <Link
                            href="/"
                            class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                            @click="close"
                        >
                            Dashboard
                        </Link>
                        <a
                            v-if="auth.user?.is_admin"
                            href="/admin"
                            class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                        >
                            Admin
                        </a>
                        <template v-if="auth.user">
                            <Link
                                href="/change-password"
                                class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                                @click="close"
                            >
                                Change Password
                            </Link>
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                type="button"
                                class="block w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                                @click="close"
                            >
                                Logout
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                href="/login"
                                class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                                @click="close"
                            >
                                Login
                            </Link>
                            <Link
                                v-if="config.registerEnabled"
                                href="/register"
                                class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60"
                                @click="close"
                            >
                                Register
                            </Link>
                        </template>
                    </DisclosurePanel>
                </Disclosure>
            </div>
        </header>

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

        <main class="flex-1 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>

        <footer class="bg-slate-900/95 border-t border-slate-800 py-3">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <a
                            href="https://github.com/andy3471/lunchrota"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-slate-400 hover:text-slate-300 transition-colors"
                            aria-label="GitHub Repository"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    fill-rule="evenodd"
                                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </a>
                        <a
                            href="https://ko-fi.com/andy3471#payment-widget"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-slate-400 hover:text-slate-300 transition-colors"
                            aria-label="Support on Ko-fi"
                        >
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M23.881 8.948c-.773-4.085-4.859-4.593-4.859-4.593H.723c-.604 0-.679.798-.679.798s-.082 7.324-.022 11.822c.164 2.424 2.586 2.672 2.586 2.672s8.267-.023 11.966-.049c2.438-.426 2.683-2.566 2.658-3.734 4.352.24 7.422-2.831 6.649-6.916zm-11.062 3.511c-1.246 1.453-4.011 3.976-4.011 3.976s-.121.119-.31.023c-.076-.057-.108-.09-.108-.09-.443-.441-3.368-3.049-4.034-3.954-.709-.965-1.041-2.7-.091-3.71.951-1.01 3.005-1.086 4.363.407 0 0 1.565-1.782 3.468-.963 1.904.82 1.832 3.011.723 4.311zm6.173.478c-.928.116-1.682.028-1.682.028V7.284h1.77s1.971.551 1.971 2.638c0 1.913-.985 2.667-2.059 3.015z" />
                            </svg>
                        </a>
                    </div>
                    <span v-if="auth.user" class="text-slate-400 text-sm">
                        {{ auth.user.name }}
                    </span>
                </div>
            </div>
        </footer>
    </div>
</template>
