<script setup>
import { useForwardPropsEmits } from 'reka-ui';
import { DrawerContent, DrawerPortal } from 'vaul-vue';
import { cn } from '@/lib/utils';
import DrawerOverlay from './DrawerOverlay.vue';

const props = defineProps({
    forceMount: { type: Boolean, required: false },
    disableOutsidePointerEvents: { type: Boolean, required: false },
    asChild: { type: Boolean, required: false },
    as: { type: null, required: false },
    class: {
        type: [Boolean, null, String, Object, Array],
        required: false,
        skipCheck: true,
    },
});
const emits = defineEmits([
    'escapeKeyDown',
    'pointerDownOutside',
    'focusOutside',
    'interactOutside',
    'openAutoFocus',
    'closeAutoFocus',
]);

const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <DrawerPortal>
        <DrawerOverlay />
        <DrawerContent
            v-bind="forwarded"
            :class="
                cn(
                    'bg-background fixed inset-x-0 bottom-0 z-50 mt-24 flex h-auto flex-col rounded-t-[10px] border',
                    props.class
                )
            "
        >
            <div class="bg-muted mx-auto mt-4 h-2 w-[100px] rounded-full" />
            <slot />
        </DrawerContent>
    </DrawerPortal>
</template>
