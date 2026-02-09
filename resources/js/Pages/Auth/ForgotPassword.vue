<script setup>
import { computed } from 'vue';
import { useForm, Link, usePage } from '@inertiajs/vue3';
import AuthCard from '@/Components/AuthCard.vue';
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
    <AuthCard title="Forgot Password">
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
    </AuthCard>
</template>
