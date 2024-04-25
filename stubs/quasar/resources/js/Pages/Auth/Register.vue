<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { useForms } from "../../Composables/rules";
import { ref } from "vue";
import Layout from "../../Layouts/AuthLayout.vue";

const { rules: rulesData } = useForms();
const rules = rulesData;
defineOptions({ layout: Layout });
const locker = ref(true);
const splitterModel = ref(50);

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    br_name: "",
    phone: "",
    details: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <q-page padding class="column items-center">
        <Head :title="$t('g.register')" />
        <div class="column items-center q-pa-md">
            <q-avatar size="120px">
                <q-img src="/img/logo.png" />
            </q-avatar>

            <q-item class="text-h5 q-pa-sm text-primary">
                {{ $t("g.create_account") }}
            </q-item>
        </div>
        <div
            class="q-pa-md"
            :style="$q.screen.width > 700 ? 'width : 900px' : 'width : 100%'"
        >
            <form @submit.prevent="submit" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <div class="q-pa-sm">
                        <q-input
                            filled
                            clearable
                            lazy-rules
                            v-model="form.name"
                            :label="$t('g.user_name')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            :error="form.errors.name ? true : false"
                            :error-message="form.errors.name"
                        >
                            <template #append>
                                <q-icon name="mdi-account-outline" />
                            </template>
                        </q-input>

                        <q-input
                            filled
                            clearable
                            lazy-rules
                            v-model="form.email"
                            :label="$t('g.login_email')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            type="email"
                            :error="form.errors.email ? true : false"
                            :error-message="form.errors.email"
                        >
                            <template #append>
                                <q-icon name="mdi-email-outline" />
                            </template>
                        </q-input>
                        <q-input
                            filled
                            clearable
                            lazy-rules
                            v-model="form.phone"
                            :label="$t('g.two_factor.phone_number')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            type="phone"
                            :error="form.errors.phone ? true : false"
                            :error-message="form.errors.phone"
                        >
                            <template #append>
                                <q-icon name="mdi-phone-outline" />
                            </template>
                        </q-input>

                        <q-input
                            filled
                            clearable
                            lazy-rules
                            v-model="form.password"
                            :label="$t('g.login_password')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            :type="`${locker ? 'password' : 'text'}`"
                            :error="form.errors.password ? true : false"
                            :error-message="form.errors.password"
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

                        <q-input
                            filled
                            clearable
                            lazy-rules
                            v-model="form.password_confirmation"
                            :rules="[(val) => !!val || $t('v.required')]"
                            :type="`${locker ? 'password' : 'text'}`"
                            :error="form.errors.password ? true : false"
                            :error-message="form.errors.password"
                            :label="$t('g.login_password_confirmation')"
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
                    </div>

                    <Link :href="route('login')" class="q-item q-link">
                        <q-item-label class="q-px-md">
                            {{ $t("g.has_account") }}</q-item-label
                        >
                    </Link>

                    <div class="q-pa-sm">
                        <q-btn
                            :label="$t('g.register')"
                            type="submit"
                            color="primary"
                        />
                        <q-btn
                            :label="$t('g.reset')"
                            type="reset"
                            color="primary"
                            flat
                            class="q-ml-sm"
                        />
                    </div>
                </q-card-section>
            </form>
        </div>
    </q-page>
</template>
