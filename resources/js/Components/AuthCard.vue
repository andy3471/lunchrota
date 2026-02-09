<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-700">
                    <h2 class="text-xl font-semibold text-white text-center">
                        {{ title }}
                    </h2>
                </div>
                <div class="p-6">
                    <slot />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
