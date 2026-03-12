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
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select';
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
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { useForm } from '@inertiajs/vue3';

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
        Select,
        SelectContent,
        SelectItem,
        SelectTrigger,
        SelectValue,
        AlertDialog,
        AlertDialogAction,
        AlertDialogCancel,
        AlertDialogContent,
        AlertDialogDescription,
        AlertDialogFooter,
        AlertDialogHeader,
        AlertDialogTitle,
        Alert,
        AlertDescription,
    },
    props: {
        classroom: {
            type: Object,
            required: true,
        },
        enrollments: {
            type: Array,
            required: true,
        },
        availableStudents: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            enrollmentToRemove: null,
        };
    },
    setup(props) {
        const form = useForm({
            student_id:
                props.availableStudents[0]?.id?.toString() ?? '',
        });
        return { form };
    },
    methods: {
        submit() {
            this.form.post(
                route('admin.classrooms.enrollments.store', this.classroom.id),
                {
                    preserveScroll: true,
                    onSuccess: () => this.form.reset('student_id'),
                }
            );
        },
        confirmRemove(enrollment) {
            this.enrollmentToRemove = enrollment;
        },
        removeEnrollment() {
            if (this.enrollmentToRemove) {
                this.$inertia.delete(
                    route(
                        'admin.enrollments.destroy',
                        this.enrollmentToRemove.id
                    ),
                    {
                        preserveScroll: true,
                        onSuccess: () => {
                            this.enrollmentToRemove = null;
                        },
                    }
                );
            }
        },
        closeRemoveDialog() {
            this.enrollmentToRemove = null;
        },
    },
};
</script>

<template>
    <Head :title="`Enrollments - ${classroom.name}`" />

    <AdminLayout>
        <template #title>Enrollments: {{ classroom.name }}</template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <Link
                        :href="route('admin.classrooms.show', classroom.id)"
                        class="text-muted-foreground hover:text-foreground text-sm"
                    >
                        ← Back to {{ classroom.name }}
                    </Link>
                </div>

                <div class="space-y-6">
                    <div
                        v-if="availableStudents.length > 0"
                        class="rounded-lg border bg-white p-6 shadow-sm"
                    >
                        <h3 class="mb-4 text-sm font-medium">
                            Enroll student
                        </h3>
                        <form
                            @submit.prevent="submit"
                            class="flex flex-wrap items-end gap-4"
                        >
                            <div class="min-w-[200px] flex-1 space-y-2">
                                <Select
                                    v-model="form.student_id"
                                    required
                                    name="student_id"
                                >
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Select student"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem
                                            v-for="student in availableStudents"
                                            :key="student.id"
                                            :value="student.id.toString()"
                                        >
                                            {{ student.last_name }},
                                            {{ student.first_name }}
                                            ({{ student.student_number }})
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <Alert
                                    v-if="form.errors.student_id"
                                    variant="destructive"
                                >
                                    <AlertDescription>{{
                                        form.errors.student_id
                                    }}</AlertDescription>
                                </Alert>
                            </div>
                            <Button
                                type="submit"
                                :disabled="form.processing"
                                :class="{ 'opacity-25': form.processing }"
                            >
                                Enroll
                            </Button>
                        </form>
                    </div>

                    <div class="overflow-hidden rounded-lg border bg-white shadow-sm">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Student #</TableHead>
                                    <TableHead>Name</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead class="text-right">
                                        Actions
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow
                                    v-for="enrollment in enrollments"
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
                                            enrollment.student?.first_name
                                        }}
                                        {{
                                            enrollment.student?.last_name
                                        }}
                                    </TableCell>
                                    <TableCell>
                                        {{
                                            enrollment.student?.email ?? '—'
                                        }}
                                    </TableCell>
                                    <TableCell class="text-right">
                                        <Button
                                            variant="destructive"
                                            size="sm"
                                            @click="
                                                confirmRemove(enrollment)
                                            "
                                        >
                                            Remove
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>

                    <p
                        v-if="
                            enrollments.length === 0 &&
                            availableStudents.length === 0
                        "
                        class="text-muted-foreground text-center text-sm"
                    >
                        No students enrolled. Create students first, then
                        enroll them here.
                    </p>
                    <p
                        v-else-if="enrollments.length === 0"
                        class="text-muted-foreground text-center text-sm"
                    >
                        No students enrolled yet. Select a student above to
                        enroll.
                    </p>
                </div>
            </div>
        </div>

        <AlertDialog
            :open="!!enrollmentToRemove"
            @update:open="(v) => !v && closeRemoveDialog()"
        >
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>
                        Remove student from classroom
                    </AlertDialogTitle>
                    <AlertDialogDescription>
                        Are you sure you want to remove
                        {{ enrollmentToRemove?.student?.first_name }}
                        {{ enrollmentToRemove?.student?.last_name }} from this
                        classroom?
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction
                        class="bg-destructive text-destructive-foreground hover:bg-destructive/90"
                        @click="removeEnrollment"
                    >
                        Remove
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AdminLayout>
</template>
