<script setup>
import { reactiveOmit } from '@vueuse/core';
import { TagsInputItem, useForwardProps } from 'reka-ui';
import { cn } from '@/lib/utils';

const props = defineProps({
    value: { type: null, required: true },
    disabled: { type: Boolean, required: false },
    asChild: { type: Boolean, required: false },
    as: { type: null, required: false },
    class: {
        type: [Boolean, null, String, Object, Array],
        required: false,
        skipCheck: true,
    },
});

const delegatedProps = reactiveOmit(props, 'class');

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
    <TagsInputItem
        v-bind="forwardedProps"
        :class="
            cn(
                'bg-secondary data-[state=active]:ring-ring ring-offset-background flex h-6 items-center rounded data-[state=active]:ring-2 data-[state=active]:ring-offset-2',
                props.class
            )
        "
    >
        <slot />
    </TagsInputItem>
</template>
