<script>
import { Button } from '@/Components/ui/button';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Head, Link, useForm } from '@inertiajs/vue3';

export default {
    components: {
        Button,
        GuestLayout,
        Input,
        Label,
        Alert,
        AlertDescription,
        Head,
        Link,
    },
    setup() {
        const form = useForm({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        });
        return { form };
    },
    methods: {
        submit() {
            this.form.post(route('register'), {
                onFinish: () =>
                    this.form.reset('password', 'password_confirmation'),
            });
        },
    },
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div class="space-y-2">
                <Label for="name">Name</Label>
                <Input
                    id="name"
                    type="text"
                    class="mt-1 w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <Alert
                    v-if="form.errors.name"
                    variant="destructive"
                    class="mt-2"
                >
                    <AlertDescription>{{ form.errors.name }}</AlertDescription>
                </Alert>
            </div>

            <div class="mt-4 space-y-2">
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    type="email"
                    class="mt-1 w-full"
                    v-model="form.email"
                    required
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

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="text-muted-foreground hover:text-foreground text-sm underline"
                >
                    Already registered?
                </Link>
                <Button
                    type="submit"
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>
