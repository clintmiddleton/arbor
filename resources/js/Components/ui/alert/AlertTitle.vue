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
    <h5
        :class="cn('mb-1 leading-none font-medium tracking-tight', props.class)"
    >
        <slot />
    </h5>
</template>
