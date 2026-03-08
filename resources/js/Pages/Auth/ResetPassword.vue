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
        email: {
            type: String,
            required: true,
        },
        token: {
            type: String,
            required: true,
        },
    },
    setup(props) {
        const form = useForm({
            token: props.token,
            email: props.email,
            password: '',
            password_confirmation: '',
        });
        return { form };
    },
    methods: {
        submit() {
            this.form.post(route('password.store'), {
                onFinish: () =>
                    this.form.reset('password', 'password_confirmation'),
            });
        },
    },
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

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

            <div class="mt-4 space-y-2">
                <Label for="password">Password</Label>
                <Input
                    id="password"
                    type="password"
                    class="mt-1 w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <Alert
                    v-if="form.errors.password"
                    variant="destructive"
                    class="mt-2"
                >
                    <AlertDescription>{{
                        form.errors.password
                    }}</AlertDescription>
                </Alert>
            </div>

            <div class="mt-4 space-y-2">
                <Label for="password_confirmation">Confirm Password</Label>
                <Input
                    id="password_confirmation"
                    type="password"
                    class="mt-1 w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <Alert
                    v-if="form.errors.password_confirmation"
                    variant="destructive"
                    class="mt-2"
                >
                    <AlertDescription>{{
                        form.errors.password_confirmation
                    }}</AlertDescription>
                </Alert>
            </div>

            <div class="mt-4 flex justify-end">
                <Button
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>
