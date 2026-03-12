<script>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { useForm } from '@inertiajs/vue3';

export default {
    components: {
        TeacherLayout,
        Head,
        Link,
        Button,
        Input,
        Label,
        Alert,
        AlertDescription,
    },
    props: {
        classroom: {
            type: Object,
            required: true,
        },
    },
    setup() {
        const today = new Date().toISOString().slice(0, 10);
        const now = new Date();
        const time =
            String(now.getHours()).padStart(2, '0') +
            ':' +
            String(now.getMinutes()).padStart(2, '0');
        const form = useForm({
            session_date: today,
            session_time: time,
        });
        return { form };
    },
    methods: {
        submit() {
            this.form.post(
                route(
                    'teacher.classrooms.attendance.store',
                    this.classroom.id
                )
            );
        },
    },
};
</script>

<template>
    <Head :title="`New Attendance - ${classroom.name}`" />

    <TeacherLayout>
        <template #title>New Attendance Session</template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <Link
                        :href="
                            route(
                                'teacher.classrooms.attendance.index',
                                classroom.id
                            )
                        "
                        class="text-muted-foreground hover:text-foreground text-sm"
                    >
                        ← Back to {{ classroom.name }} attendance
                    </Link>
                </div>

                <div class="max-w-xl rounded-lg border bg-white p-6 shadow-sm">
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="space-y-2">
                            <Label for="session_date">Date</Label>
                            <Input
                                id="session_date"
                                v-model="form.session_date"
                                type="date"
                                required
                            />
                            <Alert
                                v-if="form.errors.session_date"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.session_date
                                }}</AlertDescription>
                            </Alert>
                        </div>

                        <div class="space-y-2">
                            <Label for="session_time">Time</Label>
                            <Input
                                id="session_time"
                                v-model="form.session_time"
                                type="time"
                                required
                            />
                            <Alert
                                v-if="form.errors.session_time"
                                variant="destructive"
                            >
                                <AlertDescription>{{
                                    form.errors.session_time
                                }}</AlertDescription>
                            </Alert>
                        </div>

                        <p class="text-muted-foreground text-sm">
                            A new attendance session will be created with all
                            enrolled students marked as present. You can adjust
                            attendance on the next screen.
                        </p>

                        <div class="flex gap-4">
                            <Button
                                type="submit"
                                :disabled="form.processing"
                                :class="{ 'opacity-25': form.processing }"
                            >
                                Create session
                            </Button>
                            <Button variant="outline" asChild>
                                <Link
                                    :href="
                                        route(
                                            'teacher.classrooms.attendance.index',
                                            classroom.id
                                        )
                                    "
                                >
                                    Cancel
                                </Link>
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>
