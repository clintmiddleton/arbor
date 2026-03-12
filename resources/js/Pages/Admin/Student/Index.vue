<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
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

export default {
    components: {
        AdminLayout,
        Head,
        Link,
        Button,
        Table,
        TableBody,
        TableCell,
        TableHead,
        TableHeader,
        TableRow,
        AlertDialog,
        AlertDialogAction,
        AlertDialogCancel,
        AlertDialogContent,
        AlertDialogDescription,
        AlertDialogFooter,
        AlertDialogHeader,
        AlertDialogTitle,
    },
    props: {
        students: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            studentToDelete: null,
        };
    },
    methods: {
        confirmDelete(student) {
            this.studentToDelete = student;
        },
        deleteStudent() {
            if (this.studentToDelete) {
                this.$inertia.delete(
                    route('admin.students.destroy', this.studentToDelete.id),
                    {
                        preserveScroll: true,
                        onSuccess: () => {
                            this.studentToDelete = null;
                        },
                    }
                );
            }
        },
        closeDeleteDialog() {
            this.studentToDelete = null;
        },
    },
};
</script>

<template>
    <Head title="Students" />

    <AdminLayout>
        <template #title>Students</template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between">
                    <h2 class="text-lg font-medium text-gray-800">
                        Manage students
                    </h2>
                    <Button asChild>
                        <Link :href="route('admin.students.create')">
                            Add student
                        </Link>
                    </Button>
                </div>

                <div class="overflow-hidden rounded-lg border bg-white shadow-sm">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Student #</TableHead>
                                <TableHead>Name</TableHead>
                                <TableHead>Email</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="student in students.data"
                                :key="student.id"
                            >
                                <TableCell>{{ student.student_number }}</TableCell>
                                <TableCell>
                                    <Link
                                        :href="
                                            route(
                                                'admin.students.show',
                                                student.id
                                            )
                                        "
                                        class="font-medium text-primary hover:underline"
                                    >
                                        {{ student.first_name }}
                                        {{ student.last_name }}
                                    </Link>
                                </TableCell>
                                <TableCell>{{ student.email }}</TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Button
                                            variant="outline"
                                            size="sm"
                                            asChild
                                        >
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
                                        <Button
                                            variant="destructive"
                                            size="sm"
                                            @click="confirmDelete(student)"
                                        >
                                            Delete
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>

                <div
                    v-if="students.data.length === 0"
                    class="rounded-lg border bg-white p-8 text-center text-gray-500"
                >
                    No students yet.
                    <Link
                        :href="route('admin.students.create')"
                        class="ml-1 font-medium text-primary hover:underline"
                    >
                        Create the first student
                    </Link>
                </div>

                <div
                    v-if="students.last_page > 1"
                    class="mt-4 flex flex-wrap justify-center gap-2"
                >
                    <template v-for="link in students.links" :key="link.label">
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

        <AlertDialog
            :open="!!studentToDelete"
            @update:open="(v) => !v && closeDeleteDialog()"
        >
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Delete student</AlertDialogTitle>
                    <AlertDialogDescription>
                        Are you sure you want to delete
                        {{ studentToDelete?.first_name }}
                        {{ studentToDelete?.last_name }}? This action cannot be
                        undone.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction
                        class="bg-destructive text-destructive-foreground hover:bg-destructive/90"
                        @click="deleteStudent"
                    >
                        Delete
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AdminLayout>
</template>
