<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Button from './Button.vue';
import Toast from './Toast.vue';

const props = defineProps({
    lunchSlots: {
        type: Array,
        required: true,
    },
    loggedIn: {
        type: Boolean,
        default: false,
    },
    initialLunch: {
        type: Number,
        default: null,
    },
    available: {
        type: Boolean,
        default: false,
    },
});

const slots = ref(props.lunchSlots);
const userLunches = ref([]);
const selectedLunch = ref(props.initialLunch);
const loading = ref(false);
const slotsLoading = ref(false);
const usersLoading = ref(false);
const toast = ref(null);

onMounted(() => {
    getUserLunches();
});

const getUserLunches = async () => {
    loading.value = true;
    try {
        const response = await axios.get('./api/lunch-slots/users');
        userLunches.value = response.data;
    } catch (error) {
        console.error('Error fetching user lunches:', error);
    } finally {
        loading.value = false;
    }
};

const setLunch = async (id) => {
    if (usersLoading.value) return;

    usersLoading.value = true;
    slotsLoading.value = true;
    userLunches.value = [];

    try {
        const response = await axios.post('./api/lunch-slots/claim', { id });
        userLunches.value = response.data;
        selectedLunch.value = id;
        await getSlots();
    } catch (error) {
        showToast('error', error.response?.data || 'Failed to claim lunch slot');
        await getSlots();
    } finally {
        usersLoading.value = false;
    }
};

const removeLunch = async () => {
    usersLoading.value = true;
    userLunches.value = [];

    try {
        const response = await axios.post('./api/lunch-slots/un-claim');
        userLunches.value = response.data;
        selectedLunch.value = null;
        await getSlots();
    } catch (error) {
        showToast('error', error.response?.data || 'Failed to remove lunch slot');
        await getSlots();
    } finally {
        usersLoading.value = false;
    }
};

const getSlots = async () => {
    slotsLoading.value = true;
    try {
        const response = await axios.get('./api/lunch-slots');
        slots.value = response.data;
    } catch (error) {
        console.error('Error fetching slots:', error);
    } finally {
        slotsLoading.value = false;
    }
};

const showToast = (type, message) => {
    toast.value = { type, message };
    setTimeout(() => {
        toast.value = null;
    }, 5000);
};

const isButtonDisabled = (slot) => {
    if (!props.loggedIn) return true;
    if (slot.id === selectedLunch.value) return true;
    if (slotsLoading.value) return true;
    if (props.available && slot.available_today === 0) return true;
    return false;
};
</script>

<template>
    <div class="card overflow-hidden flex flex-col w-full h-full">
        <!-- Header -->
        <div class="px-4 py-2 border-b border-slate-700/50 flex-shrink-0">
            <h4 class="text-sm font-semibold text-slate-100 text-center">
                Lunches
            </h4>
        </div>

        <!-- Slot Buttons -->
        <div class="p-3 border-b border-slate-700/50 flex-shrink-0">
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
                    <span class="ml-1 text-xs opacity-75">({{ slot.available_today }})</span>
                </button>
                <button
                    :disabled="!loggedIn || selectedLunch === null"
                    class="px-3 py-1.5 text-sm font-medium rounded-md bg-slate-700 text-slate-300 hover:bg-slate-600 hover:text-white transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    :title="selectedLunch ? 'Remove selection' : ''"
                    @click="removeLunch"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Table -->
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
                    <tr v-if="loading || usersLoading">
                        <td colspan="2" class="text-center py-6">
                            <div class="flex items-center justify-center gap-2 text-slate-400">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                </svg>
                                <span>Loading...</span>
                            </div>
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

        <!-- Toast notification -->
        <Toast
            v-if="toast"
            :message="toast.message"
            :type="toast.type"
        />
    </div>
</template>
