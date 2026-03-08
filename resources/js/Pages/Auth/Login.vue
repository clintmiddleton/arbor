<script>
import { Button } from '@/Components/ui/button';
import { Checkbox } from '@/Components/ui/checkbox';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Head, Link, useForm } from '@inertiajs/vue3';

export default {
    components: {
        Button,
        Checkbox,
        GuestLayout,
        Input,
        Label,
        Alert,
        AlertDescription,
        Head,
        Link,
    },
    props: {
        canResetPassword: {
            type: Boolean,
        },
        status: {
            type: String,
        },
    },
    setup() {
        const form = useForm({
            email: '',
            password: '',
            remember: false,
        });
        return { form };
    },
    methods: {
        submit() {
            this.form.post(route('login'), {
                onFinish: () => this.form.reset('password'),
            });
        },
    },
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

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

            <div class="mt-4 space-y-2">
                <Label for="password">Password</Label>
                <Input
                    id="password"
                    type="password"
                    class="mt-1 w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
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

            <div class="mt-4 flex items-center space-x-2">
                <Checkbox id="remember" v-model="form.remember" />
                <Label
                    for="remember"
                    class="cursor-pointer text-sm font-normal"
                >
                    Remember me
                </Label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-muted-foreground hover:text-foreground text-sm underline"
                >
                    Forgot your password?
                </Link>
                <Button
                    type="submit"
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>
