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
                    <slot name="title">Attendance</slot>
                </h2>
                <nav class="flex items-center gap-2">
                    <Button variant="ghost" size="sm" asChild>
                        <Link
                            :href="route('teacher.classrooms.index')"
                            :class="
                                route().current('teacher.*')
                                    ? 'bg-accent text-accent-foreground'
                                    : ''
                            "
                        >
                            My Classrooms
                        </Link>
                    </Button>
                </nav>
            </div>
        </template>

        <slot />
    </AuthenticatedLayout>
</template>
