<script setup lang="ts">
import { ref, watch } from 'vue';
import LoadingSpinner from './LoadingSpinner.vue';
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

watch(() => props.roles, (newVal) => {
    userRoles.value = newVal;
}, { immediate: true });
</script>

<template>
    <div class="card overflow-hidden flex flex-col w-full h-full">
        <div class="px-4 py-2 border-b border-slate-700/50 shrink-0">
            <h4 class="text-sm font-semibold text-slate-100 text-center">
                Roles
            </h4>
        </div>

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
                                class="inline-flex items-center gap-1.5 text-xs text-slate-300"
                            >
                                <span class="h-2 w-2 rounded-full bg-emerald-400" />
                                Available
                            </span>
                            <span
                                v-else
                                class="inline-flex items-center gap-1.5 text-xs text-slate-500"
                            >
                                <span class="h-2 w-2 rounded-full bg-slate-600" />
                                Unavailable
                            </span>
                        </td>
                    </tr>
                    <tr v-if="loading">
                        <td colspan="3" class="text-center py-6">
                            <LoadingSpinner />
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
