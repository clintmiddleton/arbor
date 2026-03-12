<script>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
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
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table';
import { Badge } from '@/Components/ui/badge';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { useForm } from '@inertiajs/vue3';

const STATUS_OPTIONS = [
    { value: 'present', label: 'Present' },
    { value: 'absent', label: 'Absent' },
    { value: 'tardy', label: 'Tardy' },
    { value: 'excused', label: 'Excused' },
];

export default {
    components: {
        TeacherLayout,
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
        Table,
        TableBody,
        TableCell,
        TableHead,
        TableHeader,
        TableRow,
        Badge,
        Alert,
        AlertDescription,
    },
    props: {
        classroom: {
            type: Object,
            required: true,
        },
        session: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            statusOptions: STATUS_OPTIONS,
        };
    },
    setup(props) {
        const records = (props.session.records ?? []).map((r) => ({
            student_id: r.student_id,
            status: r.status,
            notes: r.notes ?? '',
        }));
        const form = useForm({
            records,
            submit: false,
        });
        return { form };
    },
    computed: {
        isEditable() {
            return this.session.status === 'draft';
        },
    },
    methods: {
        saveDraft() {
            this.form.submit = false;
            this.form.put(
                route(
                    'teacher.classrooms.attendance.update',
                    [this.classroom.id, this.session.id]
                )
            );
        },
        submitAttendance() {
            this.form.submit = true;
            this.form.put(
                route(
                    'teacher.classrooms.attendance.update',
                    [this.classroom.id, this.session.id]
                )
            );
        },
    },
};
</script>

<template>
    <Head :title="`Take Attendance - ${classroom.name}`" />

    <TeacherLayout>
        <template #title>
            Take Attendance: {{ classroom.name }} -
            {{ new Date(session.session_date).toLocaleDateString() }}
        </template>

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

                <div
                    v-if="!isEditable"
                    class="mb-4 rounded-lg border bg-amber-50 p-4 text-amber-800"
                >
                    This session has been {{ session.status }} and can no longer
                    be edited.
                </div>

                <div class="overflow-hidden rounded-lg border bg-white shadow-sm">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Student</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Notes</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="(record, index) in form.records"
                                :key="record.student_id"
                            >
                                <TableCell>
                                    {{
                                        session.records?.find(
                                            (r) =>
                                                r.student_id ===
                                                record.student_id
                                        )?.student?.first_name
                                    }}
                                    {{
                                        session.records?.find(
                                            (r) =>
                                                r.student_id ===
                                                record.student_id
                                        )?.student?.last_name
                                    }}
                                    ({{
                                        session.records?.find(
                                            (r) =>
                                                r.student_id ===
                                                record.student_id
                                        )?.student?.student_number
                                    }})
                                </TableCell>
                                <TableCell>
                                    <Select
                                        v-model="form.records[index].status"
                                        :disabled="!isEditable"
                                    >
                                        <SelectTrigger class="w-[140px]">
                                            <SelectValue />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem
                                                v-for="opt in statusOptions"
                                                :key="opt.value"
                                                :value="opt.value"
                                            >
                                                {{ opt.label }}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                </TableCell>
                                <TableCell>
                                    <Input
                                        v-model="form.records[index].notes"
                                        :disabled="!isEditable"
                                        type="text"
                                        placeholder="Optional notes"
                                        class="max-w-xs"
                                    />
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>

                <div
                    v-if="isEditable"
                    class="mt-6 flex gap-4"
                >
                    <Button
                        :disabled="form.processing"
                        :class="{ 'opacity-25': form.processing }"
                        @click="saveDraft"
                    >
                        Save draft
                    </Button>
                    <Button
                        variant="default"
                        :disabled="form.processing"
                        :class="{ 'opacity-25': form.processing }"
                        @click="submitAttendance"
                    >
                        Submit attendance
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
            </div>
        </div>
    </TeacherLayout>
</template>
