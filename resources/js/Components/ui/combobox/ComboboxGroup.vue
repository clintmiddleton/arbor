<script setup>
import { reactiveOmit } from '@vueuse/core';
import { ComboboxGroup, ComboboxLabel } from 'reka-ui';
import { cn } from '@/lib/utils';

const props = defineProps({
    asChild: { type: Boolean, required: false },
    as: { type: null, required: false },
    class: {
        type: [Boolean, null, String, Object, Array],
        required: false,
        skipCheck: true,
    },
    heading: { type: String, required: false },
});

const delegatedProps = reactiveOmit(props, 'class');
</script>

<template>
    <ComboboxGroup
        v-bind="delegatedProps"
        :class="
            cn(
                'text-foreground [&_[cmdk-group-heading]]:text-muted-foreground overflow-hidden p-1 [&_[cmdk-group-heading]]:px-2 [&_[cmdk-group-heading]]:py-1.5 [&_[cmdk-group-heading]]:text-xs [&_[cmdk-group-heading]]:font-medium',
                props.class
            )
        "
    >
        <ComboboxLabel
            v-if="heading"
            class="text-muted-foreground px-2 py-1.5 text-xs font-medium"
        >
            {{ heading }}
        </ComboboxLabel>
        <slot />
    </ComboboxGroup>
</template>
