<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';

import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { home } from '@/routes';
import { store } from '@/routes/login';


defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
const title = 'Log in to your account'
const description = 'Enter your email and password below to log in'
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-background p-6 md:p-10">
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <Link :href="home()" class="flex flex-col items-center gap-2 font-medium">
                    <span class="sr-only">{{ title }}</span>
                    </Link>
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">{{ title }}</h1>
                        <p class="text-center text-sm text-muted-foreground">
                            {{ description }}
                        </p>
                    </div>
                </div>

                <Head title="Log in" />

                <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <Form v-bind="store.form()" :reset-on-success="['password']" v-slot="{ errors, processing }"
                    class="flex flex-col gap-6">
                    <div class="grid gap-6">
                        <div class="grid gap-2">
                            <Label for="email">Email address</Label>
                            <Input id="email" type="email" name="email" required autofocus :tabindex="1"
                                autocomplete="email" placeholder="email@example.com" />
                            <InputError :message="errors.email" />
                        </div>

                        <div class="grid gap-2">
                            <PasswordInput id="password" name="password" required :tabindex="2"
                                autocomplete="current-password" placeholder="Password" />
                            <InputError :message="errors.password" />
                        </div>

                        <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="processing"
                            data-test="login-button">
                            <Spinner v-if="processing" />
                            Log in
                        </Button>
                    </div>
                </Form>
            </div>
        </div>
    </div>

</template>
