<script setup>
import { Link } from '@inertiajs/vue3';
import BrochureLayout from '@/Layouts/BrochureLayout.vue';
</script>

<template>
    <BrochureLayout>
        <div class="py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight">
                        Manage your team's
                        <span class="text-amber-400">lunch rota</span>
                        with ease
                    </h1>
                    <p class="mt-6 text-lg text-slate-400 max-w-2xl mx-auto">
                        LunchRota helps teams coordinate lunch schedules, manage office roles, and keep
                        everyone organised. Simple, fast, and designed for teams of any size.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-4">
                        <Link
                            href="/register"
                            class="px-6 py-3 rounded-lg text-base font-semibold bg-amber-500 text-slate-900 hover:bg-amber-400 transition-colors"
                        >
                            Create Your Team
                        </Link>
                    </div>
                </div>

                <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-slate-800/60 rounded-lg border border-slate-700/50 p-6">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Lunch Slots</h3>
                        <p class="mt-2 text-sm text-slate-400">
                            Define available lunch times and let team members claim their preferred slots. No more double-booking or confusion.
                        </p>
                    </div>

                    <div class="bg-slate-800/60 rounded-lg border border-slate-700/50 p-6">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Team Roles</h3>
                        <p class="mt-2 text-sm text-slate-400">
                            Track who's in the office, working from home, or on leave. Lunch availability updates automatically based on roles.
                        </p>
                    </div>

                    <div class="bg-slate-800/60 rounded-lg border border-slate-700/50 p-6">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Admin Panel</h3>
                        <p class="mt-2 text-sm text-slate-400">
                            Manage users, roles, and lunch slots through a powerful admin panel. Import and export data with ease.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </BrochureLayout>
</template>
