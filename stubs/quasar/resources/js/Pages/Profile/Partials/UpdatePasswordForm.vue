<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import FormData from "@/Components/form/FormData.vue";
import ActionMessage from "@/Components/ActionMessage.vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route("user-password.update"), {
        errorBag: "updatePassword",
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <form-data @submitted="updatePassword">
        <template #title>{{$t('g.change_password')}}</template>

        <template #form1>
            <q-input
                type="password"
                clearable
                filled
                v-model="form.current_password"
                :label="$t('g.current_password')"
                lazy-rules
                :rules="[(val) => !!val || $t('v.required')]"
                :error-message="form.errors.current_password"
                :error="form.errors.current_password ? true : false"
            />

            <q-input
                type="password"
                clearable
                filled
                v-model="form.password"
                :label="$t('g.new_password')"
                lazy-rules
                :rules="[(val) => !!val || $t('v.required')]"
                :error-message="form.errors.password"
                :error="form.errors.password ? true : false"
            />

            <q-input
                type="password"
                clearable
                filled
                v-model="form.password_confirmation"
                :label="$t('g.login_password_confirmation')"
            />
        </template>

        <template #form2
            >Ensure your account is using a long, random password to stay
            secure.</template
        >

        <template #actions>
            <q-btn
            flat
                :label="$t('g.save')"
                type="submit"
                color="primary"
                :loading="form.processing"
            />
            <!-- <q-btn
                        :label="$t('g.reset')"
                        type="reset"
                        color="warning"
                        flat
                        class="q-ml-sm"
                    /> -->

            <a-message :on="form.recentlySuccessful" class="me-3">
                {{ $t("g.change_password_success") }}
            </a-message>
        </template>
    </form-data>
</template>
