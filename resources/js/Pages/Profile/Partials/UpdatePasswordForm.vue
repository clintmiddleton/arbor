<script>
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { useForm } from '@inertiajs/vue3';

export default {
    components: {
        Button,
        Input,
        Label,
        Alert,
        AlertDescription,
    },
    setup() {
        const form = useForm({
            current_password: '',
            password: '',
            password_confirmation: '',
        });
        return { form };
    },
    methods: {
        updatePassword() {
            this.form.put(route('password.update'), {
                preserveScroll: true,
                onSuccess: () => this.form.reset(),
                onError: () => {
                    if (this.form.errors.password) {
                        this.form.reset('password', 'password_confirmation');
                        this.$refs.passwordInput?.$el?.focus();
                    }
                    if (this.form.errors.current_password) {
                        this.form.reset('current_password');
                        this.$refs.currentPasswordInput?.$el?.focus();
                    }
                },
            });
        },
    },
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-foreground text-lg font-medium">Update Password</h2>
            <p class="text-muted-foreground mt-1 text-sm">
                Ensure your account is using a long, random password to stay
                secure.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div class="space-y-2">
                <Label for="current_password">Current Password</Label>
                <Input
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 w-full"
                    autocomplete="current-password"
                />
                <Alert
                    v-if="form.errors.current_password"
                    variant="destructive"
                    class="mt-2"
                >
                    <AlertDescription>{{
                        form.errors.current_password
                    }}</AlertDescription>
                </Alert>
            </div>

            <div class="space-y-2">
                <Label for="password">New Password</Label>
                <Input
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 w-full"
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

            <div class="space-y-2">
                <Label for="password_confirmation">Confirm Password</Label>
                <Input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 w-full"
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

            <div class="flex items-center gap-4">
                <Button type="submit" :disabled="form.processing">Save</Button>
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-muted-foreground text-sm"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
