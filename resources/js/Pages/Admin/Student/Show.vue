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
        student: {
            type: Object,
            required: true,
        },
    },
};
</script>

<template>
    <Head
        :title="`${student.first_name} ${student.last_name} - Student`"
    />

    <AdminLayout>
        <template #title>
            Student: {{ student.first_name }} {{ student.last_name }}
        </template>

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

                <Card>
                    <CardHeader>
                        <div class="flex items-center justify-between">
                            <div>
                                <CardTitle class="text-2xl">
                                    {{ student.first_name }}
                                    {{ student.last_name }}
                                </CardTitle>
                                <CardDescription>
                                    {{ student.student_number }} •
                                    {{ student.email }}
                                </CardDescription>
                            </div>
                            <Button variant="outline" asChild>
                                <Link
                                    :href="
                                        route(
                                            'admin.students.edit',
                                            student.id
                                        )
                                    "
                                >
                                    Edit
                                </Link>
                            </Button>
                        </div>
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <dl class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <dt
                                    class="text-muted-foreground text-sm font-medium"
                                >
                                    Student Number
                                </dt>
                                <dd class="mt-1">
                                    {{ student.student_number }}
                                </dd>
                            </div>
                            <div>
                                <dt
                                    class="text-muted-foreground text-sm font-medium"
                                >
                                    First Name
                                </dt>
                                <dd class="mt-1">
                                    {{ student.first_name }}
                                </dd>
                            </div>
                            <div>
                                <dt
                                    class="text-muted-foreground text-sm font-medium"
                                >
                                    Last Name
                                </dt>
                                <dd class="mt-1">
                                    {{ student.last_name }}
                                </dd>
                            </div>
                            <div>
                                <dt
                                    class="text-muted-foreground text-sm font-medium"
                                >
                                    Email
                                </dt>
                                <dd class="mt-1">{{ student.email }}</dd>
                            </div>
                        </dl>

                        <div v-if="student.enrollments?.length">
                            <h3 class="mb-2 text-sm font-medium">
                                Enrolled Classrooms
                            </h3>
                            <div class="overflow-hidden rounded-lg border">
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead>Classroom</TableHead>
                                            <TableHead>Grade</TableHead>
                                            <TableHead>Academic Year</TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        <TableRow
                                            v-for="enrollment in student.enrollments"
                                            :key="enrollment.id"
                                        >
                                            <TableCell>
                                                <Link
                                                    v-if="enrollment.classroom"
                                                    :href="
                                                        route(
                                                            'admin.classrooms.show',
                                                            enrollment.classroom
                                                                .id
                                                        )
                                                    "
                                                    class="font-medium text-primary hover:underline"
                                                >
                                                    {{
                                                        enrollment.classroom
                                                            ?.name ?? '—'
                                                    }}
                                                </Link>
                                                <span v-else>—</span>
                                            </TableCell>
                                            <TableCell>
                                                {{
                                                    enrollment.classroom
                                                        ?.grade_level ?? '—'
                                                }}
                                            </TableCell>
                                            <TableCell>
                                                {{
                                                    enrollment.classroom
                                                        ?.academic_year ?? '—'
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
                            Not enrolled in any classrooms.
                        </p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
