<script setup>
import { cn } from '@/lib/utils';

const props = defineProps({
    class: {
        type: [Boolean, null, String, Object, Array],
        required: false,
        skipCheck: true,
    },
});
</script>

<template>
    <div :class="cn('bg-muted animate-pulse rounded-md', props.class)" />
</template>
