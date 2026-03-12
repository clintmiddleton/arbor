<script>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card';

export default {
    components: {
        TeacherLayout,
        Head,
        Link,
        Button,
        Card,
        CardContent,
        CardDescription,
        CardHeader,
        CardTitle,
    },
    props: {
        classrooms: {
            type: Array,
            required: true,
        },
    },
};
</script>

<template>
    <Head title="My Classrooms" />

    <TeacherLayout>
        <template #title>My Classrooms</template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h2 class="text-lg font-medium text-gray-800">
                        Your classrooms
                    </h2>
                    <p class="text-muted-foreground mt-1 text-sm">
                        Select a classroom to take attendance.
                    </p>
                </div>

                <div
                    v-if="classrooms.length === 0"
                    class="rounded-lg border bg-white p-8 text-center text-gray-500"
                >
                    You have no classrooms assigned. Contact an administrator
                    to be assigned to a classroom.
                </div>

                <div
                    v-else
                    class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <Card
                        v-for="classroom in classrooms"
                        :key="classroom.id"
                        class="overflow-hidden"
                    >
                        <CardHeader>
                            <CardTitle class="text-lg">
                                {{ classroom.name }}
                            </CardTitle>
                            <CardDescription>
                                {{ classroom.grade_level }} •
                                {{ classroom.academic_year }} •
                                {{ classroom.enrollments_count ?? 0 }}
                                students
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="flex gap-2">
                                <Button asChild>
                                    <Link
                                        :href="
                                            route(
                                                'teacher.classrooms.attendance.index',
                                                classroom.id
                                            )
                                        "
                                    >
                                        Take Attendance
                                    </Link>
                                </Button>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>
