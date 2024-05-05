<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { useForms } from "../../Composables/rules";
import { ref } from "vue";
import Layout from "../../Layouts/AuthLayout.vue";

const { rules: rulesData } = useForms();
const rules = rulesData;
defineOptions({ layout: Layout });
const locker = ref(true);
defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <q-page class="column items-center">
        <Head :title="$t('g.login')" />
        <div class="q-pa-md" style="width: 400px">
            <div class="column items-center q-pa-md">
                <q-avatar size="120px">
                    <q-img src="/img/logo.png" />
                </q-avatar>

                <q-item class="text-h5 q-pa-sm">
                    {{ $t("g.login") }}
                </q-item>
            </div>
            <q-form @submit="submit" @reset="form.reset()" class="q-gutter-md">
                <q-input
                    filled
                    clearable
                    v-model="form.email"
                    :label="$t('g.login_email')"
                    lazy-rules
                    :rules="rules.required"
                    :error-message="form.errors.email"
                    :error="form.errors.email ? true : false"
                    type="email"
                >
                    <template #append>
                        <q-icon name="mdi-email-outline" />
                    </template>
                </q-input>

                <q-input
                    filled
                    :type="locker ? 'password' : 'text'"
                    v-model="form.password"
                    :label="$t('g.login_password')"
                    lazy-rules
                    :rules="rules.required"
                    :error-message="form.errors.password"
                    :error="form.errors.password ? true : false"
                    clearable
                >
                    <template #append>
                        <q-icon
                            :name="`${
                                locker
                                    ? 'mdi-eye-off-outline'
                                    : 'mdi-eye-outline'
                            }`"
                            @click="locker = !locker"
                            class="cursor-pointer"
                        />
                    </template>
                </q-input>
                <q-toggle
                    v-model="form.remember"
                    :label="$t('g.remember_me')"
                />
                <Link :href="route('register')" class="q-item q-link">
                    <q-item-label class="q-px-md">
                        {{ $t("g.create_account") }}</q-item-label
                    >
                </Link>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="q-item q-link"
                >
                    <q-item-label class="q-px-md">
                        {{ $t("g.forgot_password") }}</q-item-label
                    >
                </Link>
                <div>
                    <q-btn
                        :label="$t('g.login')"
                        type="submit"
                        color="primary"
                    />
                    <q-btn
                        :label="$t('g.reset')"
                        type="reset"
                        color="white"
                        flat
                        class="q-ml-sm"
                    />
                </div>
            </q-form>
        </div>
    </q-page>
</template>
