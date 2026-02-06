<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import LunchSelector from '@/Components/LunchSelector.vue';
import RoleSelector from '@/Components/RoleSelector.vue';
import { Calendar } from 'v-calendar';
import 'v-calendar/style.css';

const props = defineProps({
    lunchSlots: {
        type: Array,
        default: () => [],
    },
    initialSlot: {
        type: Number,
        default: null,
    },
    available: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();
const config = computed(() => page.props.config);
const auth = computed(() => page.props.auth);

const date = ref(new Date());

const isLoggedIn = computed(() => !!auth.value.user);

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
                <RoleSelector :date="date" />
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
                            @dayclick="(day) => { 
                                date = new Date(day.date);
                            }"
                        />
                    </div>
                </div>
            </div>

            <!-- Lunches Panel -->
            <div :class="config.rolesEnabled ? 'order-3 lg:order-3 flex' : 'lg:col-span-3 max-w-2xl mx-auto w-full flex'">
                <LunchSelector
                    :lunch-slots="lunchSlots"
                    :logged-in="isLoggedIn"
                    :initial-lunch="initialSlot"
                    :available="available"
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
