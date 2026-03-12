<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select';
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
        Select,
        SelectContent,
        SelectItem,
        SelectTrigger,
        SelectValue,
        Alert,
        AlertDescription,
    },
    props: {
        teachers: {
            type: Array,
            required: true,
        },
    },
    setup(props) {
        const form = useForm({
            name: '',
            grade_level: '',
            academic_year: '',
            teacher_id: props.teachers[0]?.id?.toString() ?? '',
        });
        return { form };
    },
    methods: {
        submit() {
            this.form.post(route('admin.classrooms.store'));
        },
    },
};
</script>

<template>
    <Head title="Create Classroom" />

    <AdminLayout>
        <template #title>Create Classroom</template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <Link
                        :href="route('admin.classrooms.index')"
                        class="text-muted-foreground hover:text-foreground text-sm"
                    >
                        ← Back to classrooms
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
                                placeholder="e.g. Math Grade 5"
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
                            <Label for="grade_level">Grade Level</Label>
                            <Input
                                id="grade_level"
                                v-model="form.grade_level"
                                type="text"
                                required
                                placeholder="e.g. 5"
                            />
                            <Alert
                                v-if="form.errors.grade_level"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.grade_level
                                }}</AlertDescription>
                            </Alert>
                        </div>

                        <div class="space-y-2">
                            <Label for="academic_year">Academic Year</Label>
                            <Input
                                id="academic_year"
                                v-model="form.academic_year"
                                type="text"
                                required
                                placeholder="e.g. 2024-2025"
                            />
                            <Alert
                                v-if="form.errors.academic_year"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.academic_year
                                }}</AlertDescription>
                            </Alert>
                        </div>

                        <div class="space-y-2">
                            <Label for="teacher_id">Teacher</Label>
                            <Select
                                v-model="form.teacher_id"
                                required
                                name="teacher_id"
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Select teacher" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="teacher in teachers"
                                        :key="teacher.id"
                                        :value="teacher.id.toString()"
                                    >
                                        {{ teacher.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <Alert
                                v-if="form.errors.teacher_id"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.teacher_id
                                }}</AlertDescription>
                            </Alert>
                        </div>

                        <div class="flex gap-4">
                            <Button
                                type="submit"
                                :disabled="form.processing"
                                :class="{ 'opacity-25': form.processing }"
                            >
                                Create classroom
                            </Button>
                            <Button variant="outline" asChild>
                                <Link :href="route('admin.classrooms.index')">
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
