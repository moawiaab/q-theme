<script setup>
import { useForm } from "@inertiajs/vue3";
import { useForms } from "../../Composables/rules";
import { ref } from "vue";
import Layout from "../../Layouts/AuthLayout.vue";

const { rules: rulesData } = useForms();
const rules = rulesData;
defineOptions({ layout: Layout });
const locker = ref(true);
const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Reset Password" />

    <q-page class="column items-center">
        <Head :title="$t('g.reset_password')" />

        <div class="column items-center q-pa-md">
                <q-avatar size="120px">
                    <q-img src="/img/logo.png" />
                </q-avatar>

                <q-item class="text-h5 q-pa-sm text-primary">
                    {{ $t("g.reset_password") }}
                </q-item>
            </div>
        <div class="q-pa-md" style="width: 400px">
            <form @submit.prevent="submit">
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
                                locker ? 'mdi-eye-off-outline' : 'mdi-eye-outline'
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
                                locker ? 'mdi-eye-off-outline' : 'mdi-eye-outline'
                            }`"
                            @click="locker = !locker"
                            class="cursor-pointer"
                        />
                    </template>
                </q-input>

                <div class="q-pa-sm">
                    <q-btn
                        :label="$t('g.reset_password')"
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
            </form>
        </div>
    </q-page>
</template>
../../Composable/rules
