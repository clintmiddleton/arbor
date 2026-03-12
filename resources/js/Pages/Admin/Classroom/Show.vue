<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table';

export default {
    components: {
        AdminLayout,
        Head,
        Link,
        Button,
        Card,
        CardContent,
        CardDescription,
        CardHeader,
        CardTitle,
        Table,
        TableBody,
        TableCell,
        TableHead,
        TableHeader,
        TableRow,
    },
    props: {
        classroom: {
            type: Object,
            required: true,
        },
    },
};
</script>

<template>
    <Head :title="`${classroom.name} - Classroom`" />

    <AdminLayout>
        <template #title>Classroom: {{ classroom.name }}</template>

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

                <Card>
                    <CardHeader>
                        <div class="flex items-center justify-between">
                            <div>
                                <CardTitle class="text-2xl">
                                    {{ classroom.name }}
                                </CardTitle>
                                <CardDescription>
                                    {{ classroom.grade_level }} •
                                    {{ classroom.academic_year }}
                                </CardDescription>
                            </div>
                            <div class="flex items-center gap-2">
                                <Button variant="outline" asChild>
                                    <Link
                                        :href="
                                            route(
                                                'admin.classrooms.edit',
                                                classroom.id
                                            )
                                        "
                                    >
                                        Edit
                                    </Link>
                                </Button>
                                <Button asChild>
                                    <Link
                                        :href="
                                            route(
                                                'admin.classrooms.enrollments.index',
                                                classroom.id
                                            )
                                        "
                                    >
                                        Manage Enrollments
                                    </Link>
                                </Button>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <dl class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <dt
                                    class="text-muted-foreground text-sm font-medium"
                                >
                                    Name
                                </dt>
                                <dd class="mt-1">{{ classroom.name }}</dd>
                            </div>
                            <div>
                                <dt
                                    class="text-muted-foreground text-sm font-medium"
                                >
                                    Grade Level
                                </dt>
                                <dd class="mt-1">
                                    {{ classroom.grade_level }}
                                </dd>
                            </div>
                            <div>
                                <dt
                                    class="text-muted-foreground text-sm font-medium"
                                >
                                    Academic Year
                                </dt>
                                <dd class="mt-1">
                                    {{ classroom.academic_year }}
                                </dd>
                            </div>
                            <div>
                                <dt
                                    class="text-muted-foreground text-sm font-medium"
                                >
                                    Teacher
                                </dt>
                                <dd class="mt-1">
                                    {{ classroom.teacher?.name ?? '—' }}
                                </dd>
                            </div>
                        </dl>

                        <div v-if="classroom.enrollments?.length">
                            <h3 class="mb-2 text-sm font-medium">
                                Enrolled Students
                            </h3>
                            <div
                                class="overflow-hidden rounded-lg border"
                            >
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead>Student #</TableHead>
                                            <TableHead>Name</TableHead>
                                            <TableHead>Email</TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        <TableRow
                                            v-for="enrollment in classroom.enrollments"
                                            :key="enrollment.id"
                                        >
                                            <TableCell>
                                                {{
                                                    enrollment.student
                                                        ?.student_number ?? '—'
                                                }}
                                            </TableCell>
                                            <TableCell>
                                                {{
                                                    enrollment.student
                                                        ?.first_name
                                                }}
                                                {{
                                                    enrollment.student
                                                        ?.last_name
                                                }}
                                            </TableCell>
                                            <TableCell>
                                                {{
                                                    enrollment.student
                                                        ?.email ?? '—'
                                                }}
                                            </TableCell>
                                        </TableRow>
                                    </TableBody>
                                </Table>
                            </div>
                        </div>
                        <p
                            v-else
                            class="text-muted-foreground text-sm"
                        >
                            No students enrolled. Add enrollments to manage the
                            roster.
                        </p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
