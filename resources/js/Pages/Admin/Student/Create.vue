<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
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
        Alert,
        AlertDescription,
    },
    setup() {
        const form = useForm({
            student_number: '',
            first_name: '',
            last_name: '',
            email: '',
        });
        return { form };
    },
    methods: {
        submit() {
            this.form.post(route('admin.students.store'));
        },
    },
};
</script>

<template>
    <Head title="Create Student" />

    <AdminLayout>
        <template #title>Create Student</template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <Link
                        :href="route('admin.students.index')"
                        class="text-muted-foreground hover:text-foreground text-sm"
                    >
                        ← Back to students
                    </Link>
                </div>

                <div class="max-w-xl rounded-lg border bg-white p-6 shadow-sm">
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="space-y-2">
                            <Label for="student_number">Student Number</Label>
                            <Input
                                id="student_number"
                                v-model="form.student_number"
                                type="text"
                                required
                                placeholder="e.g. STU001"
                            />
                            <Alert
                                v-if="form.errors.student_number"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.student_number
                                }}</AlertDescription>
                            </Alert>
                        </div>

                        <div class="space-y-2">
                            <Label for="first_name">First Name</Label>
                            <Input
                                id="first_name"
                                v-model="form.first_name"
                                type="text"
                                required
                            />
                            <Alert
                                v-if="form.errors.first_name"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.first_name
                                }}</AlertDescription>
                            </Alert>
                        </div>

                        <div class="space-y-2">
                            <Label for="last_name">Last Name</Label>
                            <Input
                                id="last_name"
                                v-model="form.last_name"
                                type="text"
                                required
                            />
                            <Alert
                                v-if="form.errors.last_name"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.last_name
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

                        <div class="flex gap-4">
                            <Button
                                type="submit"
                                :disabled="form.processing"
                                :class="{ 'opacity-25': form.processing }"
                            >
                                Create student
                            </Button>
                            <Button variant="outline" asChild>
                                <Link :href="route('admin.students.index')">
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
