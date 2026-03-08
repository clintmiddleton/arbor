<script>
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/Components/ui/alert-dialog';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { useForm } from '@inertiajs/vue3';

export default {
    components: {
        AlertDialog,
        AlertDialogAction,
        AlertDialogCancel,
        AlertDialogContent,
        AlertDialogDescription,
        AlertDialogFooter,
        AlertDialogHeader,
        AlertDialogTitle,
        Button,
        Input,
        Label,
        Alert,
        AlertDescription,
    },
    setup() {
        const form = useForm({
            password: '',
        });
        return { form };
    },
    data() {
        return {
            confirmingUserDeletion: false,
        };
    },
    methods: {
        confirmUserDeletion() {
            this.confirmingUserDeletion = true;
            this.$nextTick(() => this.$refs.passwordInput?.$el?.focus());
        },
        deleteUser() {
            this.form.delete(route('profile.destroy'), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.passwordInput?.$el?.focus(),
                onFinish: () => this.form.reset(),
            });
        },
        closeModal() {
            this.confirmingUserDeletion = false;
            this.form.clearErrors();
            this.form.reset();
        },
    },
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-foreground text-lg font-medium">Delete Account</h2>
            <p class="text-muted-foreground mt-1 text-sm">
                Once your account is deleted, all of its resources and data will
                be permanently deleted. Before deleting your account, please
                download any data or information that you wish to retain.
            </p>
        </header>

        <Button variant="destructive" @click="confirmUserDeletion">
            Delete Account
        </Button>

        <AlertDialog
            :open="confirmingUserDeletion"
            @update:open="
                (v) => {
                    confirmingUserDeletion = v;
                    if (!v) {
                        form.clearErrors();
                        form.reset();
                    }
                }
            "
        >
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>
                        Are you sure you want to delete your account?
                    </AlertDialogTitle>
                    <AlertDialogDescription>
                        Once your account is deleted, all of its resources and
                        data will be permanently deleted. Please enter your
                        password to confirm you would like to permanently delete
                        your account.
                    </AlertDialogDescription>
                </AlertDialogHeader>

                <div class="mt-6 space-y-2">
                    <Label for="password" class="sr-only">Password</Label>
                    <Input
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="w-3/4"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
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

                <AlertDialogFooter class="mt-6">
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <Button
                        variant="destructive"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Delete Account
                    </Button>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </section>
</template>
