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
        classrooms: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            classroomToDelete: null,
        };
    },
    methods: {
        confirmDelete(classroom) {
            this.classroomToDelete = classroom;
        },
        deleteClassroom() {
            if (this.classroomToDelete) {
                this.$inertia.delete(
                    route('admin.classrooms.destroy', this.classroomToDelete.id),
                    {
                        preserveScroll: true,
                        onSuccess: () => {
                            this.classroomToDelete = null;
                        },
                    }
                );
            }
        },
        closeDeleteDialog() {
            this.classroomToDelete = null;
        },
    },
};
</script>

<template>
    <Head title="Classrooms" />

    <AdminLayout>
        <template #title>Classrooms</template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between">
                    <h2 class="text-lg font-medium text-gray-800">
                        Manage classrooms
                    </h2>
                    <Button asChild>
                        <Link :href="route('admin.classrooms.create')">
                            Add classroom
                        </Link>
                    </Button>
                </div>

                <div class="overflow-hidden rounded-lg border bg-white shadow-sm">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Grade</TableHead>
                                <TableHead>Academic Year</TableHead>
                                <TableHead>Teacher</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="classroom in classrooms.data"
                                :key="classroom.id"
                            >
                                <TableCell>
                                    <Link
                                        :href="
                                            route(
                                                'admin.classrooms.show',
                                                classroom.id
                                            )
                                        "
                                        class="font-medium text-primary hover:underline"
                                    >
                                        {{ classroom.name }}
                                    </Link>
                                </TableCell>
                                <TableCell>{{ classroom.grade_level }}</TableCell>
                                <TableCell>
                                    {{ classroom.academic_year }}
                                </TableCell>
                                <TableCell>
                                    {{ classroom.teacher?.name ?? '—' }}
                                </TableCell>
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
                                                        'admin.classrooms.edit',
                                                        classroom.id
                                                    )
                                                "
                                            >
                                                Edit
                                            </Link>
                                        </Button>
                                        <Button
                                            variant="destructive"
                                            size="sm"
                                            @click="confirmDelete(classroom)"
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
                    v-if="classrooms.data.length === 0"
                    class="rounded-lg border bg-white p-8 text-center text-gray-500"
                >
                    No classrooms yet.
                    <Link
                        :href="route('admin.classrooms.create')"
                        class="ml-1 font-medium text-primary hover:underline"
                    >
                        Create the first classroom
                    </Link>
                </div>

                <div
                    v-if="classrooms.last_page > 1"
                    class="mt-4 flex flex-wrap justify-center gap-2"
                >
                    <template v-for="link in classrooms.links" :key="link.label">
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
            :open="!!classroomToDelete"
            @update:open="(v) => !v && closeDeleteDialog()"
        >
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Delete classroom</AlertDialogTitle>
                    <AlertDialogDescription>
                        Are you sure you want to delete
                        {{ classroomToDelete?.name }}? This action cannot be
                        undone.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction
                        class="bg-destructive text-destructive-foreground hover:bg-destructive/90"
                        @click="deleteClassroom"
                    >
                        Delete
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AdminLayout>
</template>
