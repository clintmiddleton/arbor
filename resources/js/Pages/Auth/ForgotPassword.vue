<script>
import { Button } from '@/Components/ui/button';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Head, useForm } from '@inertiajs/vue3';

export default {
    components: {
        Button,
        GuestLayout,
        Input,
        Label,
        Alert,
        AlertDescription,
        Head,
    },
    props: {
        status: {
            type: String,
        },
    },
    setup() {
        const form = useForm({
            email: '',
        });
        return { form };
    },
    methods: {
        submit() {
            this.form.post(route('password.email'));
        },
    },
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <p class="text-muted-foreground mb-4 text-sm">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </p>

        <Alert
            v-if="status"
            variant="default"
            class="mb-4 border-green-200 bg-green-50 text-green-800"
        >
            <AlertDescription>{{ status }}</AlertDescription>
        </Alert>

        <form @submit.prevent="submit">
            <div class="space-y-2">
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    type="email"
                    class="mt-1 w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <Alert
                    v-if="form.errors.email"
                    variant="destructive"
                    class="mt-2"
                >
                    <AlertDescription>{{ form.errors.email }}</AlertDescription>
                </Alert>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Button
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Email Password Reset Link
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>
