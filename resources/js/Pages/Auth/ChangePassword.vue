<script setup>
import { computed } from 'vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';

const page = usePage();
const config = computed(() => page.props.config || {});

const form = useForm({
    currentpassword: '',
    newpassword: '',
    newpassword_confirmation: '',
});

const submit = () => {
    form.post('/change-password', {
        preserveScroll: false,
        onSuccess: () => {
            form.reset();
        },
    });
};

const isDemoMode = config.value?.demoMode;
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <div class="card">
                <div class="px-6 py-4 border-b border-slate-700/50">
                    <h2 class="text-xl font-semibold text-white text-center">
                        Change Password
                    </h2>
                </div>

                <div class="p-6">
                    <p v-if="isDemoMode" class="text-slate-400 text-center mb-6 p-3 bg-slate-500/10 rounded-lg">
                        Password changes are disabled in demo mode.
                    </p>

                    <form v-else @submit.prevent="submit" class="space-y-4">
                        <Input
                            v-model="form.currentpassword"
                            type="password"
                            label="Current Password"
                            :error="form.errors.currentpassword"
                            required
                            autocomplete="current-password"
                            autofocus
                        />

                        <Input
                            v-model="form.newpassword"
                            type="password"
                            label="New Password"
                            :error="form.errors.newpassword"
                            required
                            autocomplete="new-password"
                        />

                        <Input
                            v-model="form.newpassword_confirmation"
                            type="password"
                            label="Confirm New Password"
                            required
                            autocomplete="new-password"
                        />

                        <div class="flex items-center justify-between pt-4">
                            <Link
                                href="/"
                                class="text-sm text-slate-400 hover:text-slate-300 transition-colors"
                            >
                                Cancel
                            </Link>

                            <Button
                                type="submit"
                                :loading="form.processing"
                                :disabled="form.processing"
                            >
                                Change Password
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
