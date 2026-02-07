<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { home } from '@/routes';
import AppLayout from '@/Layouts/AppLayout.vue';
import LunchSelector from '@/Components/LunchSelector.vue';
import RoleSelector from '@/Components/RoleSelector.vue';
import { Calendar } from 'v-calendar';
import 'v-calendar/style.css';
import type { HomePageData } from '@/Types/generated';

const props = defineProps<HomePageData>();

const page = usePage();
const config = computed(() => page.props.config);
const auth = computed(() => page.props.auth);

// Get initial date from props (which comes from server based on URL query param)
// Server defaults to today if no date param, so props.selectedDate should always have a value
const date = ref(new Date(props.selectedDate));
const dateLoading = ref(false);
let lastHandledDateString = props.selectedDate;
let isInitialMount = true;

const isLoggedIn = computed(() => !!auth.value.user);

// Check if the selected date is today
const isToday = computed(() => {
    if (!props.selectedDate) return false;
    const today = new Date();
    // Use local date strings to avoid timezone issues
    const todayString = today.getFullYear() + '-' + 
        String(today.getMonth() + 1).padStart(2, '0') + '-' + 
        String(today.getDate()).padStart(2, '0');
    // props.selectedDate is already in YYYY-MM-DD format from the server
    const selectedDateString = props.selectedDate;
    return todayString === selectedDateString;
});

// Sync local date with prop when server updates it (but don't trigger reload)
watch(() => props.selectedDate, (newDateString) => {
    if (newDateString) {
        const newDate = new Date(newDateString);
        const currentDateString = date.value?.toISOString().split('T')[0];
        // Only update if different to avoid infinite loop
        if (currentDateString !== newDateString) {
            date.value = newDate;
            // Update last handled date string to prevent reload trigger
            lastHandledDateString = newDateString;
        }
    }
});

// Function to handle date change and reload data
const handleDateChange = (newDate: Date) => {
    if (!newDate) return;
    
    const dateString = newDate.toISOString().split('T')[0];
    const currentDateString = props.selectedDate;
    
    // Skip if we're already on this date (prevents unnecessary reloads)
    if (dateString === currentDateString) {
        return;
    }
    
    dateLoading.value = true;
    
    // Use router.get with data - Inertia will add it as query params
    router.get('/', {
        date: dateString
    }, {
        preserveScroll: true,
        only: ['userLunches', 'roles', 'lunchSlots', 'initialSlot', 'selectedDate'],
        onFinish: () => {
            dateLoading.value = false;
        },
        onError: () => {
            dateLoading.value = false;
        },
    });
};

// Watch date changes and reload data (skip initial sync)
watch(() => date.value, (newDate) => {
    // Skip the initial mount to prevent reload on page load
    if (isInitialMount) {
        isInitialMount = false;
        lastHandledDateString = props.selectedDate;
        return;
    }
    
    if (!newDate) {
        return;
    }
    
    const dateString = newDate.toISOString().split('T')[0];
    
    // Only handle if the date string actually changed
    if (dateString && dateString !== lastHandledDateString) {
        lastHandledDateString = dateString;
        handleDateChange(newDate);
    }
}, { immediate: false });

const selectedDateAttributes = computed(() => {
    if (!date.value) return [];
    return [
        {
            key: 'selected',
            highlight: {
                color: 'orange',
                fillMode: 'solid',
            },
            dates: date.value,
        },
    ];
});
</script>

<template>
    <AppLayout>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-stretch">
            <!-- Roles Panel -->
            <div v-if="config.rolesEnabled" class="order-1 lg:order-1 flex">
                <RoleSelector :date="date" :roles="props.roles" :loading="dateLoading" />
            </div>

            <!-- Date Picker Panel -->
            <div v-if="config.rolesEnabled" class="order-2 lg:order-2 flex">
                <div class="bg-slate-800/60 rounded-lg border border-slate-700/50 overflow-hidden flex flex-col w-full self-start">
                    <div class="px-4 py-2 border-b border-slate-700/50 flex-shrink-0">
                        <h4 class="text-sm font-medium text-slate-200 text-center">
                            Select Date
                        </h4>
                    </div>
                    <div class="p-3 w-full">
                        <Calendar
                            v-model="date"
                            :attributes="selectedDateAttributes"
                            class="w-full"
                            :columns="1"
                            :rows="1"
                            mode="date"
                            :is-required="false"
                            @update:model-value="(value) => {
                                if (value) {
                                    date.value = Array.isArray(value) ? value[0] : value;
                                }
                            }"
                            @dayclick="(day) => {
                                const newDate = new Date(day.date);
                                date.value = newDate;
                                // Call handleDateChange directly since watch might not fire immediately
                                handleDateChange(newDate);
                            }"
                        />
                    </div>
                </div>
            </div>

            <!-- Lunches Panel -->
            <div :class="config.rolesEnabled ? 'order-3 lg:order-3 flex' : 'lg:col-span-3 max-w-2xl mx-auto w-full flex'">
                <LunchSelector
                    :lunch-slots="props.lunchSlots"
                    :logged-in="isLoggedIn"
                    :initial-lunch="props.initialSlot"
                    :available="props.available"
                    :user-lunches="props.userLunches"
                    :loading="dateLoading"
                    :can-select="isToday"
                />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Style v-calendar for dark theme */
:deep(.vc-container) {
    background-color: transparent !important;
    border: none !important;
    width: 100% !important;
    max-width: 100% !important;
}

:deep(.vc-pane-container) {
    width: 100% !important;
    max-width: 100% !important;
}

:deep(.vc-pane) {
    width: 100% !important;
}

:deep(.vc-weeks) {
    width: 100% !important;
}

:deep(.vc-weekday) {
    color: #94a3b8;
    font-weight: 600;
    font-size: 0.75rem;
}

:deep(.vc-day) {
    color: #e2e8f0;
}

:deep(.vc-day-content:hover) {
    background-color: #334155 !important;
    color: #f1f5f9 !important;
}

/* Selected date highlight - target all possible highlight classes */
:deep(.vc-highlight),
:deep(.vc-highlight-base-start),
:deep(.vc-highlight-base-end),
:deep(.vc-highlight-base),
:deep(.vc-highlight-content),
:deep(.vc-highlight-content-wrapper) {
    background-color: #e6730a !important;
    border-color: #e6730a !important;
    color: #ffffff !important;
}

:deep(.vc-day-content.selected-date-highlight),
:deep(.vc-day-content.selected-date-highlight .vc-day-label),
:deep(.vc-day.selected-date-highlight .vc-day-content),
:deep(.vc-day.selected-date-highlight .vc-day-label) {
    background-color: #e6730a !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    box-shadow: 0 0 0 2px rgba(230, 115, 10, 0.5), 0 2px 4px rgba(230, 115, 10, 0.3) !important;
    border-radius: 0.375rem !important;
}

/* Target any day that has a highlight */
:deep(.vc-day:has(.vc-highlight)) .vc-day-content,
:deep(.vc-day:has(.vc-highlight-base)) .vc-day-content {
    background-color: #e6730a !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    box-shadow: 0 0 0 2px rgba(230, 115, 10, 0.5), 0 2px 4px rgba(230, 115, 10, 0.3) !important;
    border-radius: 0.375rem !important;
}

/* Also target is-selected class if it exists */
:deep(.vc-day-content.is-selected),
:deep(.vc-day-content.is-selected.is-not-in-month),
:deep(.vc-day-content.is-selected.is-today) {
    background-color: #e6730a !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    box-shadow: 0 0 0 2px rgba(230, 115, 10, 0.5), 0 2px 4px rgba(230, 115, 10, 0.3) !important;
    transform: scale(1.05);
}

/* Today's date when not selected */
:deep(.vc-day-content.is-today:not(.is-selected)) {
    border: 2px solid #e6730a !important;
    color: #e6730a !important;
    font-weight: 600;
    background-color: transparent !important;
}

:deep(.vc-day-content.is-not-in-month) {
    color: #94a3b8 !important;
    opacity: 0.6;
}

:deep(.vc-header) {
    color: #f1f5f9 !important;
}

:deep(.vc-title) {
    color: #f1f5f9 !important;
    font-weight: 600;
}

:deep(.vc-nav-container) {
    color: #94a3b8;
}

:deep(.vc-nav-container:hover) {
    color: #e6730a;
}

:deep(.vc-day-content) {
    cursor: pointer;
}

/* Force highlight color override for orange */
:deep([style*="orange"]),
:deep([class*="orange"]) {
    background-color: #e6730a !important;
    color: #ffffff !important;
}

/* Target any day content that might be selected */
:deep(.vc-day-content[aria-selected="true"]),
:deep(.vc-day-content[data-selected="true"]) {
    background-color: #e6730a !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    box-shadow: 0 0 0 2px rgba(230, 115, 10, 0.5), 0 2px 4px rgba(230, 115, 10, 0.3) !important;
    border-radius: 0.375rem !important;
}
</style>
