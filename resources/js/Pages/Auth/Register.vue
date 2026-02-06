<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-700">
                    <h2 class="text-xl font-semibold text-white text-center">
                        Register
                    </h2>
                </div>

                <div class="p-6">
                    <form @submit.prevent="submit" class="space-y-4">
                        <Input
                            v-model="form.name"
                            type="text"
                            label="Name"
                            :error="form.errors.name"
                            required
                            autocomplete="name"
                            autofocus
                        />

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
                            label="Password"
                            :error="form.errors.password"
                            required
                            autocomplete="new-password"
                        />

                        <Input
                            v-model="form.password_confirmation"
                            type="password"
                            label="Confirm Password"
                            required
                            autocomplete="new-password"
                        />

                        <div class="flex justify-end pt-4">
                            <Button
                                type="submit"
                                :loading="form.processing"
                                :disabled="form.processing"
                            >
                                Register
                            </Button>
                        </div>
                    </form>

                    <div class="mt-6 pt-6 border-t border-gray-700 text-center">
                        <p class="text-gray-400 text-sm">
                            Already have an account?
                            <Link href="/login" class="text-primary-400 hover:text-primary-300 transition-colors">
                                Login
                            </Link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
