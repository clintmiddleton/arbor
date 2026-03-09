<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Checkbox } from '@/Components/ui/checkbox';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { useForm } from '@inertiajs/vue3';

export default {
    components: {
        AdminLayout,
        Head,
        Link,
        Button,
        Input,
        Label,
        Checkbox,
        Alert,
        AlertDescription,
    },
    setup() {
        const form = useForm({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            is_admin: false,
        });
        return { form };
    },
    methods: {
        submit() {
            this.form.post(route('admin.users.store'), {
                onFinish: () =>
                    this.form.reset('password', 'password_confirmation'),
            });
        },
    },
};
</script>

<template>
    <Head title="Create User" />

    <AdminLayout>
        <template #title>Create User</template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <Link
                        :href="route('admin.users.index')"
                        class="text-muted-foreground hover:text-foreground text-sm"
                    >
                        ← Back to users
                    </Link>
                </div>

                <div class="max-w-xl rounded-lg border bg-white p-6 shadow-sm">
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="space-y-2">
                            <Label for="name">Name</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                autocomplete="name"
                            />
                            <Alert
                                v-if="form.errors.name"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.name
                                }}</AlertDescription>
                            </Alert>
                        </div>

                        <div class="space-y-2">
                            <Label for="email">Email</Label>
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                autocomplete="email"
                            />
                            <Alert
                                v-if="form.errors.email"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.email
                                }}</AlertDescription>
                            </Alert>
                        </div>

                        <div class="space-y-2">
                            <Label for="password">Password</Label>
                            <Input
                                id="password"
                                v-model="form.password"
                                type="password"
                                required
                                autocomplete="new-password"
                            />
                            <Alert
                                v-if="form.errors.password"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.password
                                }}</AlertDescription>
                            </Alert>
                        </div>

                        <div class="space-y-2">
                            <Label for="password_confirmation">
                                Confirm password
                            </Label>
                            <Input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                            />
                            <Alert
                                v-if="form.errors.password_confirmation"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.password_confirmation
                                }}</AlertDescription>
                            </Alert>
                        </div>

                        <div class="flex items-center space-x-2">
                            <Checkbox
                                id="is_admin"
                                v-model="form.is_admin"
                            />
                            <Label for="is_admin" class="cursor-pointer">
                                Administrator
                            </Label>
                        </div>
                        <Alert
                            v-if="form.errors.is_admin"
                            variant="destructive"
                        >
                            <AlertDescription>{{
                                form.errors.is_admin
                            }}</AlertDescription>
                        </Alert>

                        <div class="flex gap-4">
                            <Button
                                type="submit"
                                :disabled="form.processing"
                                :class="{ 'opacity-25': form.processing }"
                            >
                                Create user
                            </Button>
                            <Button variant="outline" asChild>
                                <Link :href="route('admin.users.index')">
                                    Cancel
                                </Link>
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
