<script setup>
import { reactiveOmit } from '@vueuse/core';
import { NavigationMenuViewport, useForwardProps } from 'reka-ui';
import { cn } from '@/lib/utils';

const props = defineProps({
    forceMount: { type: Boolean, required: false },
    align: { type: String, required: false },
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
    <div class="absolute top-full left-0 flex justify-center">
        <NavigationMenuViewport
            v-bind="forwardedProps"
            :class="
                cn(
                    'origin-top-center bg-popover text-popover-foreground data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-90 relative left-[var(--reka-navigation-menu-viewport-left)] mt-1.5 h-[--reka-navigation-menu-viewport-height] w-full overflow-hidden rounded-md border shadow-lg md:w-[--reka-navigation-menu-viewport-width]',
                    props.class
                )
            "
        />
    </div>
</template>
