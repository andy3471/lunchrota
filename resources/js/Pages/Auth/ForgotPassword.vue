<script setup>
import { useForm, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';

const page = usePage();
const status = computed(() => page.props.status);

const form = useForm({
    email: '',
});

const submit = () => {
    form.post('/forgot-password');
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-700">
                    <h2 class="text-xl font-semibold text-white text-center">
                        Forgot Password
                    </h2>
                </div>

                <div class="p-6">
                    <p class="text-gray-400 text-sm mb-6">
                        Forgot your password? No problem. Just enter your email address and we'll send you a password reset link.
                    </p>

                    <div
                        v-if="status"
                        class="mb-6 p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-emerald-400 text-sm"
                    >
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit" class="space-y-4">
                        <Input
                            v-model="form.email"
                            type="email"
                            label="Email Address"
                            :error="form.errors.email"
                            required
                            autocomplete="email"
                            autofocus
                        />

                        <div class="flex items-center justify-between pt-4">
                            <Link
                                href="/login"
                                class="text-sm text-gray-400 hover:text-gray-300 transition-colors"
                            >
                                Back to login
                            </Link>

                            <Button
                                type="submit"
                                :loading="form.processing"
                                :disabled="form.processing"
                            >
                                Send Reset Link
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
