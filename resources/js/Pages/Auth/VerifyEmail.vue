<script>
import { Button } from '@/Components/ui/button';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Head, Link, useForm } from '@inertiajs/vue3';

export default {
    components: {
        Button,
        GuestLayout,
        Alert,
        AlertDescription,
        Head,
        Link,
    },
    props: {
        status: {
            type: String,
        },
    },
    setup() {
        const form = useForm({});
        return { form };
    },
    computed: {
        verificationLinkSent() {
            return this.status === 'verification-link-sent';
        },
    },
    methods: {
        submit() {
            this.form.post(route('verification.send'));
        },
    },
};
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <p class="text-muted-foreground mb-4 text-sm">
            Thanks for signing up! Before getting started, could you verify your
            email address by clicking on the link we just emailed to you? If you
            didn't receive the email, we will gladly send you another.
        </p>

        <Alert
            v-if="verificationLinkSent"
            variant="default"
            class="mb-4 border-green-200 bg-green-50 text-green-800"
        >
            <AlertDescription>
                A new verification link has been sent to the email address you
                provided during registration.
            </AlertDescription>
        </Alert>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <Button
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </Button>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-muted-foreground hover:text-foreground text-sm underline"
                >
                    Log Out
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
