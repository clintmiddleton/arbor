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
    setup() {
        const form = useForm({
            password: '',
        });
        return { form };
    },
    methods: {
        submit() {
            this.form.post(route('password.confirm'), {
                onFinish: () => this.form.reset(),
            });
        },
    },
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />

        <p class="text-muted-foreground mb-4 text-sm">
            This is a secure area of the application. Please confirm your
            password before continuing.
        </p>

        <form @submit.prevent="submit">
            <div class="space-y-2">
                <Label for="password">Password</Label>
                <Input
                    id="password"
                    type="password"
                    class="mt-1 w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
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

            <div class="mt-4 flex justify-end">
                <Button
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Confirm
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>
