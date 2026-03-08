<script>
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Link, useForm, usePage } from '@inertiajs/vue3';

export default {
    components: {
        Button,
        Input,
        Label,
        Alert,
        AlertDescription,
        Link,
    },
    props: {
        mustVerifyEmail: {
            type: Boolean,
        },
        status: {
            type: String,
        },
    },
    setup() {
        const user = usePage().props.auth.user;
        const form = useForm({
            name: user.name,
            email: user.email,
        });
        return { form };
    },
    computed: {
        user() {
            return this.$page.props.auth.user;
        },
    },
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-foreground text-lg font-medium">
                Profile Information
            </h2>
            <p class="text-muted-foreground mt-1 text-sm">
                Update your account's profile information and email address.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
            <div class="space-y-2">
                <Label for="name">Name</Label>
                <Input
                    id="name"
                    type="text"
                    class="mt-1 w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <Alert
                    v-if="form.errors.name"
                    variant="destructive"
                    class="mt-2"
                >
                    <AlertDescription>{{ form.errors.name }}</AlertDescription>
                </Alert>
            </div>

            <div class="space-y-2">
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    type="email"
                    class="mt-1 w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <Alert
                    v-if="form.errors.email"
                    variant="destructive"
                    class="mt-2"
                >
                    <AlertDescription>{{ form.errors.email }}</AlertDescription>
                </Alert>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-foreground mt-2 text-sm">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="text-muted-foreground hover:text-foreground underline"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>
                <Alert
                    v-if="status === 'verification-link-sent'"
                    variant="default"
                    class="mt-2 border-green-200 bg-green-50 text-green-800"
                >
                    <AlertDescription
                        >A new verification link has been sent to your email
                        address.</AlertDescription
                    >
                </Alert>
            </div>

            <div class="flex items-center gap-4">
                <Button type="submit" :disabled="form.processing">Save</Button>
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-muted-foreground text-sm"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
