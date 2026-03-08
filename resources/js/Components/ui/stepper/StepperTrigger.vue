<script setup>
import { reactiveOmit } from '@vueuse/core';

import { StepperTrigger, useForwardProps } from 'reka-ui';
import { cn } from '@/lib/utils';

const props = defineProps({
    asChild: { type: Boolean, required: false },
    as: { type: null, required: false },
    class: {
        type: [Boolean, null, String, Object, Array],
        required: false,
        skipCheck: true,
    },
});

const delegatedProps = reactiveOmit(props, 'class');

const forwarded = useForwardProps(delegatedProps);
</script>

<template>
    <StepperTrigger
        v-bind="forwarded"
        :class="
            cn(
                'flex flex-col items-center gap-2 rounded-md p-2 text-center',
                props.class
            )
        "
    >
        <slot />
    </StepperTrigger>
</template>
