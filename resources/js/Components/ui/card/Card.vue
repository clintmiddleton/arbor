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
    <div
        :class="
            cn(
                'bg-card text-card-foreground rounded-lg border shadow-sm',
                props.class
            )
        "
    >
        <slot />
    </div>
</template>
