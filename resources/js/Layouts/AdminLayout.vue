<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button } from '@/Components/ui/button';
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        AuthenticatedLayout,
        Button,
        Link,
    },
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl leading-tight font-semibold text-gray-800">
                    <slot name="title">Admin</slot>
                </h2>
                <nav class="flex items-center gap-2">
                    <Button variant="ghost" size="sm" asChild>
                        <Link
                            :href="route('admin.classrooms.index')"
                            :class="
                                route().current('admin.classrooms.*')
                                    ? 'bg-accent text-accent-foreground'
                                    : ''
                            "
                        >
                            Classrooms
                        </Link>
                    </Button>
                    <Button variant="ghost" size="sm" asChild>
                        <Link
                            :href="route('admin.students.index')"
                            :class="
                                route().current('admin.students.*')
                                    ? 'bg-accent text-accent-foreground'
                                    : ''
                            "
                        >
                            Students
                        </Link>
                    </Button>
                    <Button variant="ghost" size="sm" asChild>
                        <Link
                            :href="route('admin.users.index')"
                            :class="
                                route().current('admin.users.*')
                                    ? 'bg-accent text-accent-foreground'
                                    : ''
                            "
                        >
                            Users
                        </Link>
                    </Button>
                </nav>
            </div>
        </template>

        <slot />
    </AuthenticatedLayout>
</template>
