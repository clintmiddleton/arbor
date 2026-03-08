<script setup>
import { reactiveOmit } from '@vueuse/core';
import { MenubarRoot, useForwardPropsEmits } from 'reka-ui';
import { cn } from '@/lib/utils';

const props = defineProps({
    modelValue: { type: String, required: false },
    defaultValue: { type: String, required: false },
    dir: { type: String, required: false },
    loop: { type: Boolean, required: false },
    class: {
        type: [Boolean, null, String, Object, Array],
        required: false,
        skipCheck: true,
    },
});
const emits = defineEmits(['update:modelValue']);

const delegatedProps = reactiveOmit(props, 'class');

const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
    <MenubarRoot
        v-bind="forwarded"
        :class="
            cn(
                'bg-background flex h-10 items-center gap-x-1 rounded-md border p-1',
                props.class
            )
        "
    >
        <slot />
    </MenubarRoot>
</template>
