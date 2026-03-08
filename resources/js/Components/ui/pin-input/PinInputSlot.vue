<script setup>
import { reactiveOmit } from '@vueuse/core';
import { PinInputInput, useForwardProps } from 'reka-ui';
import { cn } from '@/lib/utils';

const props = defineProps({
    index: { type: Number, required: true },
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
    <PinInputInput
        v-bind="forwardedProps"
        :class="
            cn(
                'focus:ring-ring border-input relative flex h-10 w-10 items-center justify-center border-y border-r text-center text-sm transition-all first:rounded-l-md first:border-l last:rounded-r-md focus:relative focus:z-10 focus:ring-2 focus:outline-none',
                props.class
            )
        "
    />
</template>
