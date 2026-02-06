<script setup>
import { computed } from 'vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';

const page = usePage();
const config = computed(() => page.props.config);

const form = useForm({
    email: config.value.demoMode ? 'admin@admin.com' : '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-700">
                    <h2 class="text-xl font-semibold text-white text-center">
                        Login
                    </h2>
                </div>

                <div class="p-6">
                    <p v-if="config.demoMode" class="text-amber-400 text-sm text-center mb-6 p-3 bg-amber-500/10 rounded-lg">
                        Demo mode is enabled. Use the pre-filled credentials to log in.
                    </p>

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

                        <Input
                            v-model="form.password"
                            type="password"
                            label="Password"
                            :error="form.errors.password"
                            required
                            autocomplete="current-password"
                        />

                        <div class="flex items-center">
                            <input
                                id="remember"
                                v-model="form.remember"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-600 bg-gray-700 text-primary-600 focus:ring-primary-500 focus:ring-offset-gray-800"
                            />
                            <label for="remember" class="ml-2 text-sm text-gray-300">
                                Remember me
                            </label>
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <Link
                                v-if="config.resetPasswordEnabled"
                                href="/forgot-password"
                                class="text-sm text-primary-400 hover:text-primary-300 transition-colors"
                            >
                                Forgot your password?
                            </Link>
                            <span v-else></span>

                            <Button
                                type="submit"
                                :loading="form.processing"
                                :disabled="form.processing"
                            >
                                Login
                            </Button>
                        </div>
                    </form>

                    <div v-if="config.registerEnabled" class="mt-6 pt-6 border-t border-gray-700 text-center">
                        <p class="text-gray-400 text-sm">
                            Don't have an account?
                            <Link href="/register" class="text-primary-400 hover:text-primary-300 transition-colors">
                                Register
                            </Link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
