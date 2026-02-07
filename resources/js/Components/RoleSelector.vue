<script setup lang="ts">
import { ref, watch } from 'vue';
import type { RoleData } from '@/Types/generated';

interface Props {
    date: Date;
    roles?: RoleData[];
    loading?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    roles: () => [],
    loading: false,
});

const userRoles = ref<RoleData[]>(props.roles);

// Watch for prop changes (when Inertia reloads data)
watch(() => props.roles, (newVal) => {
    userRoles.value = newVal;
}, { immediate: true });
</script>

<template>
    <div class="card overflow-hidden flex flex-col w-full h-full">
        <!-- Header -->
        <div class="px-4 py-2 border-b border-slate-700/50 flex-shrink-0">
            <h4 class="text-sm font-semibold text-slate-100 text-center">
                Roles
            </h4>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto flex-1 overflow-y-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-2/5">Name</th>
                        <th class="w-2/5">Role</th>
                        <th class="w-1/5">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(user, index) in userRoles"
                        :key="`${user.name}-${user.role}-${index}`"
                        :class="{ 'bg-slate-800/30': user.available === 0 }"
                    >
                        <td class="text-slate-100">{{ user.name }}</td>
                        <td class="text-slate-300">{{ user.role }}</td>
                        <td>
                            <span
                                v-if="user.available === 1"
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-400"
                            >
                                Available
                            </span>
                            <span
                                v-else
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-500/20 text-slate-400"
                            >
                                Unavailable
                            </span>
                        </td>
                    </tr>
                    <tr v-if="loading">
                        <td colspan="3" class="text-center py-6">
                            <div class="flex items-center justify-center gap-2 text-slate-400">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                </svg>
                                <span>Loading...</span>
                            </div>
                        </td>
                    </tr>
                    <tr v-else-if="userRoles.length === 0">
                        <td colspan="3" class="text-center py-6 text-slate-500">
                            No roles assigned for this date
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
