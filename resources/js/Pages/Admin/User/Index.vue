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
import { Badge } from '@/Components/ui/badge';

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
        Badge,
    },
    props: {
        users: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            userToDelete: null,
        };
    },
    methods: {
        confirmDelete(user) {
            this.userToDelete = user;
        },
        deleteUser() {
            if (this.userToDelete) {
                this.$inertia.delete(
                    route('admin.users.destroy', this.userToDelete.id),
                    {
                        preserveScroll: true,
                        onSuccess: () => {
                            this.userToDelete = null;
                        },
                    }
                );
            }
        },
        closeDeleteDialog() {
            this.userToDelete = null;
        },
    },
};
</script>

<template>
    <Head title="Users" />

    <AdminLayout>
        <template #title>Users</template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between">
                    <h2 class="text-lg font-medium text-gray-800">
                        Manage users
                    </h2>
                    <Button asChild>
                        <Link :href="route('admin.users.create')">
                            Add user
                        </Link>
                    </Button>
                </div>

                <div class="overflow-hidden rounded-lg border bg-white shadow-sm">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Email</TableHead>
                                <TableHead>Role</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="user in users.data"
                                :key="user.id"
                            >
                                <TableCell>
                                    <Link
                                        :href="route('admin.users.show', user.id)"
                                        class="font-medium text-primary hover:underline"
                                    >
                                        {{ user.name }}
                                    </Link>
                                </TableCell>
                                <TableCell>{{ user.email }}</TableCell>
                                <TableCell>
                                    <div class="flex flex-wrap gap-1">
                                        <Badge
                                            v-if="user.is_admin"
                                            variant="secondary"
                                        >
                                            Admin
                                        </Badge>
                                        <Badge
                                            v-if="user.is_teacher"
                                            variant="outline"
                                        >
                                            Teacher
                                        </Badge>
                                        <span
                                            v-if="!user.is_admin && !user.is_teacher"
                                            class="text-muted-foreground text-sm"
                                        >
                                            User
                                        </span>
                                    </div>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Button
                                            variant="outline"
                                            size="sm"
                                            asChild
                                        >
                                            <Link
                                                :href="route('admin.users.edit', user.id)"
                                            >
                                                Edit
                                            </Link>
                                        </Button>
                                        <Button
                                            v-if="user.id !== $page.props.auth.user?.id"
                                            variant="destructive"
                                            size="sm"
                                            @click="confirmDelete(user)"
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
                    v-if="users.data.length === 0"
                    class="rounded-lg border bg-white p-8 text-center text-gray-500"
                >
                    No users yet.
                    <Link
                        :href="route('admin.users.create')"
                        class="ml-1 font-medium text-primary hover:underline"
                    >
                        Create the first user
                    </Link>
                </div>

                <div
                    v-if="users.last_page > 1"
                    class="mt-4 flex flex-wrap justify-center gap-2"
                >
                    <template v-for="link in users.links" :key="link.label">
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
            :open="!!userToDelete"
            @update:open="(v) => !v && closeDeleteDialog()"
        >
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Delete user</AlertDialogTitle>
                    <AlertDialogDescription>
                        Are you sure you want to delete
                        {{ userToDelete?.name }}? This action cannot be undone.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction
                        class="bg-destructive text-destructive-foreground hover:bg-destructive/90"
                        @click="deleteUser"
                    >
                        Delete
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AdminLayout>
</template>
