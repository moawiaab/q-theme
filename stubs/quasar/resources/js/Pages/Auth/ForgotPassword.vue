<script setup>
import { useForm } from "@inertiajs/vue3";
import { useForms } from "../../Composables/rules";
import { ref } from "vue";
import Layout from "../../Layouts/AuthLayout.vue";

const { rules: rulesData } = useForms();
const rules = rulesData;
defineOptions({ layout: Layout });

defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <q-page class="column items-center">
        <Head :title="$t('g.forgot_password')" />

        <div class="column items-center q-pa-md">
                <q-avatar size="120px">
                    <q-img src="/img/logo.png" />
                </q-avatar>

                <q-item class="text-h5 q-pa-sm text-primary">
                    {{ $t("g.forgot_password") }}
                </q-item>
            </div>
        <div class="q-pa-md" style="width: 400px">
            <q-chat-message
            v-if="status"
                :text="[status]"
            >
                <template #avatar>
                    <q-avatar icon="mdi-email" color="grey-4" class="q-mr-sm"/>
                </template>
            </q-chat-message>

            <form @submit.prevent="submit">
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

                <q-btn
                    :label="$t('g.send_password')"
                    type="submit"
                    color="primary"
                    :disabled="form.processing"
                />
                <q-btn
                    :label="$t('g.reset')"
                    type="reset"
                    color="primary"
                    flat
                    class="q-ml-sm"
                />
            </form>
        </div>
    </q-page>
</template>
../../Composable/rules
