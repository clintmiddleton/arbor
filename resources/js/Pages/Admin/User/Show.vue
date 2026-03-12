<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Badge } from '@/Components/ui/badge';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card';

export default {
    components: {
        AdminLayout,
        Head,
        Link,
        Button,
        Badge,
        Card,
        CardContent,
        CardDescription,
        CardHeader,
        CardTitle,
    },
    props: {
        user: {
            type: Object,
            required: true,
        },
    },
};
</script>

<template>
    <Head :title="`${user.name} - User`" />

    <AdminLayout>
        <template #title>User: {{ user.name }}</template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <Link
                        :href="route('admin.users.index')"
                        class="text-muted-foreground hover:text-foreground text-sm"
                    >
                        ← Back to users
                    </Link>
                </div>

                <Card>
                    <CardHeader>
                        <div class="flex items-center justify-between">
                            <div>
                                <CardTitle class="text-2xl">
                                    {{ user.name }}
                                </CardTitle>
                                <CardDescription>
                                    {{ user.email }}
                                </CardDescription>
                            </div>
                            <div class="flex items-center gap-2">
                                <Badge v-if="user.is_admin" variant="secondary">
                                    Admin
                                </Badge>
                                <Button variant="outline" asChild>
                                    <Link
                                        :href="route('admin.users.edit', user.id)"
                                    >
                                        Edit
                                    </Link>
                                </Button>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <dl class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-muted-foreground text-sm font-medium">
                                    Name
                                </dt>
                                <dd class="mt-1">{{ user.name }}</dd>
                            </div>
                            <div>
                                <dt class="text-muted-foreground text-sm font-medium">
                                    Email
                                </dt>
                                <dd class="mt-1">{{ user.email }}</dd>
                            </div>
                            <div>
                                <dt class="text-muted-foreground text-sm font-medium">
                                    Role
                                </dt>
                                <dd class="mt-1">
                                    <div class="flex flex-wrap gap-1">
                                        <Badge v-if="user.is_admin" variant="secondary">
                                            Administrator
                                        </Badge>
                                        <Badge v-if="user.is_teacher" variant="outline">
                                            Teacher
                                        </Badge>
                                        <span
                                            v-if="!user.is_admin && !user.is_teacher"
                                        >
                                            User
                                        </span>
                                    </div>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-muted-foreground text-sm font-medium">
                                    Created
                                </dt>
                                <dd class="mt-1">
                                    {{ new Date(user.created_at).toLocaleDateString() }}
                                </dd>
                            </div>
                        </dl>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
