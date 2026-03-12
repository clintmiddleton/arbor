<script>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table';
import { Badge } from '@/Components/ui/badge';

export default {
    components: {
        TeacherLayout,
        Head,
        Link,
        Button,
        Table,
        TableBody,
        TableCell,
        TableHead,
        TableHeader,
        TableRow,
        Badge,
    },
    props: {
        classroom: {
            type: Object,
            required: true,
        },
        sessions: {
            type: Object,
            required: true,
        },
    },
};
</script>

<template>
    <Head :title="`Attendance - ${classroom.name}`" />

    <TeacherLayout>
        <template #title>Attendance: {{ classroom.name }}</template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <Link
                            :href="route('teacher.classrooms.index')"
                            class="text-muted-foreground hover:text-foreground text-sm"
                        >
                            ← Back to classrooms
                        </Link>
                        <h2 class="mt-1 text-lg font-medium text-gray-800">
                            Attendance sessions
                        </h2>
                    </div>
                    <Button asChild>
                        <Link
                            :href="
                                route(
                                    'teacher.classrooms.attendance.create',
                                    classroom.id
                                )
                            "
                        >
                            New session
                        </Link>
                    </Button>
                </div>

                <div class="overflow-hidden rounded-lg border bg-white shadow-sm">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Date</TableHead>
                                <TableHead>Time</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead class="text-right">
                                    Actions
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="session in sessions.data"
                                :key="session.id"
                            >
                                <TableCell>
                                    {{
                                        new Date(
                                            session.session_date
                                        ).toLocaleDateString()
                                    }}
                                </TableCell>
                                <TableCell>
                                    {{ session.session_time }}
                                </TableCell>
                                <TableCell>
                                    <Badge
                                        :variant="
                                            session.status === 'submitted'
                                                ? 'default'
                                                : session.status === 'locked'
                                                  ? 'secondary'
                                                  : 'outline'
                                        "
                                    >
                                        {{ session.status }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="text-right">
                                    <Button
                                        v-if="session.status === 'draft'"
                                        variant="outline"
                                        size="sm"
                                        asChild
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'teacher.classrooms.attendance.edit',
                                                    [
                                                        classroom.id,
                                                        session.id,
                                                    ]
                                                )
                                            "
                                        >
                                            Take attendance
                                        </Link>
                                    </Button>
                                    <Button
                                        v-else
                                        variant="ghost"
                                        size="sm"
                                        asChild
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'teacher.classrooms.attendance.edit',
                                                    [
                                                        classroom.id,
                                                        session.id,
                                                    ]
                                                )
                                            "
                                        >
                                            View
                                        </Link>
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>

                <div
                    v-if="sessions.data.length === 0"
                    class="rounded-lg border bg-white p-8 text-center text-gray-500"
                >
                    No attendance sessions yet.
                    <Link
                        :href="
                            route(
                                'teacher.classrooms.attendance.create',
                                classroom.id
                            )
                        "
                        class="ml-1 font-medium text-primary hover:underline"
                    >
                        Create the first session
                    </Link>
                </div>

                <div
                    v-if="sessions.last_page > 1"
                    class="mt-4 flex flex-wrap justify-center gap-2"
                >
                    <template v-for="link in sessions.links" :key="link.label">
                        <Button
                            v-if="link.url && !link.active"
                            variant="outline"
                            size="sm"
                            asChild
                        >
                            <Link :href="link.url">
                                <span v-html="link.label" />
                            </Link>
                        </Button>
                        <Button
                            v-else-if="link.url && link.active"
                            variant="outline"
                            size="sm"
                            class="font-bold"
                        >
                            <span v-html="link.label" />
                        </Button>
                        <span
                            v-else
                            class="flex items-center px-3 text-sm text-gray-400"
                            v-html="link.label"
                        />
                    </template>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>
