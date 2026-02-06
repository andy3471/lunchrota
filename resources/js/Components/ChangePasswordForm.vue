<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import Input from './Input.vue';
import Button from './Button.vue';

const emit = defineEmits(['success']);
const page = usePage();

const form = useForm({
    currentpassword: '',
    newpassword: '',
    newpassword_confirmation: '',
});

const submit = () => {
    form.post('/change-password', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            emit('success');
        },
    });
};

const isDemoMode = page.props.config?.demoMode;
</script>

<template>
    <div>
        <p v-if="isDemoMode" class="text-gray-400 text-center py-4">
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

            <div class="flex justify-end gap-3 pt-4">
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
</template>
