<script setup>
import { reactiveOmit } from '@vueuse/core';
import { TabsContent } from 'reka-ui';
import { cn } from '@/lib/utils';

const props = defineProps({
    value: { type: [String, Number], required: true },
    forceMount: { type: Boolean, required: false },
    asChild: { type: Boolean, required: false },
    as: { type: null, required: false },
    class: {
        type: [Boolean, null, String, Object, Array],
        required: false,
        skipCheck: true,
    },
});

const delegatedProps = reactiveOmit(props, 'class');
</script>

<template>
    <TabsContent
        :class="
            cn(
                'ring-offset-background focus-visible:ring-ring mt-2 focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none',
                props.class
            )
        "
        v-bind="delegatedProps"
    >
        <slot />
    </TabsContent>
</template>
