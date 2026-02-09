<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AuthCard from '@/Components/AuthCard.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/reset-password', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthCard title="Reset Password">
        <form @submit.prevent="submit" class="space-y-4">
            <Input
                v-model="form.email"
                type="email"
                label="Email Address"
                :error="form.errors.email"
                required
                autocomplete="email"
            />

            <Input
                v-model="form.password"
                type="password"
                label="New Password"
                :error="form.errors.password"
                required
                autocomplete="new-password"
                autofocus
            />

            <Input
                v-model="form.password_confirmation"
                type="password"
                label="Confirm New Password"
                required
                autocomplete="new-password"
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
                    Reset Password
                </Button>
            </div>
        </form>
    </AuthCard>
</template>
