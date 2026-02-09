<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { claim, unclaim } from '@/actions/App/Http/Controllers/Lunch/ClaimController';
import Toast from './Toast.vue';
import LoadingSpinner from './LoadingSpinner.vue';
import type { LunchSlotData, UserLunchData } from '@/Types/generated';

interface Props {
    lunchSlots: LunchSlotData[];
    loggedIn?: boolean;
    initialLunch?: number | null;
    available?: boolean;
    userLunches?: UserLunchData[];
    loading?: boolean;
    canSelect?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    loggedIn: false,
    initialLunch: null,
    available: false,
    userLunches: () => [],
    loading: false,
    canSelect: true,
});

const slots = ref<LunchSlotData[]>(props.lunchSlots);
const userLunches = ref<UserLunchData[]>(props.userLunches);
const selectedLunch = ref<number | null>(props.initialLunch ?? null);
const usersLoading = ref(false);
const toast = ref<{ type: string; message: string } | null>(null);

watch(() => props.userLunches, (newVal) => {
    userLunches.value = newVal;
}, { immediate: true });

watch(() => props.lunchSlots, (newVal) => {
    slots.value = newVal;
}, { immediate: true });

watch(() => props.initialLunch, (newVal) => {
    selectedLunch.value = newVal ?? null;
}, { immediate: true });

const setLunch = (id: number) => {
    if (usersLoading.value) return;

    usersLoading.value = true;
    userLunches.value = [];

    router.post(claim().url, { id }, {
        preserveScroll: true,
        onSuccess: () => {
            usersLoading.value = false;
        },
        onError: (errors) => {
            usersLoading.value = false;
            const errorMessage = errors.id?.[0] || errors.message || 'Failed to claim lunch slot';
            showToast('error', errorMessage);
        },
    });
};

const removeLunch = () => {
    if (usersLoading.value) return;

    usersLoading.value = true;
    userLunches.value = [];

    router.delete(unclaim().url, {
        preserveScroll: true,
        onSuccess: () => {
            usersLoading.value = false;
        },
        onError: (errors) => {
            usersLoading.value = false;
            const errorMessage = errors.message || 'Failed to remove lunch slot';
            showToast('error', errorMessage);
        },
    });
};

const showToast = (type: string, message: string) => {
    toast.value = { type, message };
    setTimeout(() => {
        toast.value = null;
    }, 5000);
};

const isButtonDisabled = (slot: LunchSlotData) => {
    if (!props.loggedIn) return true;
    if (!props.canSelect) return true;
    if (slot.id === selectedLunch.value) return true;
    if (props.available && slot.available_slots === 0) return true;
    return false;
};

const isRemoveDisabled = () => {
    return !props.loggedIn || selectedLunch.value === null || !props.canSelect;
};
</script>

<template>
    <div class="card overflow-hidden flex flex-col w-full h-full">
        <div class="px-4 py-2 border-b border-slate-700/50 shrink-0">
            <h4 class="text-sm font-semibold text-slate-100 text-center">
                Lunches
            </h4>
        </div>

        <div class="p-3 border-b border-slate-700/50 shrink-0">
            <div class="flex gap-2">
                <button
                    v-for="slot in slots"
                    :key="slot.id"
                    :disabled="isButtonDisabled(slot)"
                    class="flex-1 px-3 py-1.5 text-sm font-medium rounded-md transition-all duration-150"
                    :class="[
                        slot.id === selectedLunch
                            ? 'bg-primary-500 text-white shadow-md shadow-primary-500/30'
                            : 'bg-slate-700 text-slate-100 hover:bg-slate-600',
                        isButtonDisabled(slot) ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'
                    ]"
                    @click="setLunch(slot.id)"
                >
                    {{ slot.time }}
                    <span class="ml-1 text-xs opacity-75">({{ slot.available_slots }})</span>
                </button>
                <button
                    :disabled="isRemoveDisabled()"
                    class="px-3 py-1.5 text-sm font-medium rounded-md bg-slate-700 text-slate-300 hover:bg-slate-600 hover:text-white transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    :title="canSelect ? '' : 'You can only modify lunch slots for today'"
                    @click="removeLunch"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto flex-1 overflow-y-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-2/3">Name</th>
                        <th class="w-1/3">Lunch Slot</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in userLunches" :key="user.id">
                        <td class="text-slate-100">{{ user.name }}</td>
                        <td class="text-slate-300">{{ user.time }}</td>
                    </tr>
                    <tr v-if="usersLoading || loading">
                        <td colspan="2" class="text-center py-6">
                            <LoadingSpinner />
                        </td>
                    </tr>
                    <tr v-else-if="userLunches.length === 0">
                        <td colspan="2" class="text-center py-6 text-slate-500">
                            No lunch reservations yet
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Toast
            v-if="toast"
            :message="toast.message"
            :type="toast.type"
        />
    </div>
</template>
