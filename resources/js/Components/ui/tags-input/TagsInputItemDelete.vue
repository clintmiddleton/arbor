<script setup>
import { reactiveOmit } from '@vueuse/core';
import { X } from 'lucide-vue-next';
import { TagsInputItemDelete, useForwardProps } from 'reka-ui';
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

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
    <TagsInputItemDelete
        v-bind="forwardedProps"
        :class="cn('mr-1 flex rounded bg-transparent', props.class)"
    >
        <slot>
            <X class="h-4 w-4" />
        </slot>
    </TagsInputItemDelete>
</template>
