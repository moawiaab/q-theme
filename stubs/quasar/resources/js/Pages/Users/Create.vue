<template>
    <q-page padding>
        <h-title :title="$t('input.user.title_new')" />

        <q-card class="q-px-sm" flat>
            <q-card-section>
                <div class="text-h6">{{ $t("input.user.title_new") }}</div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <q-splitter
                        v-model="setting.splitterModel"
                        style="height: 100%"
                    >
                        <template v-slot:before>
                            <div class="q-pa-sm">
                                <q-input
                                    clearable
                                    filled
                                    v-model="form.name"
                                    :label="$t('g.user_name')"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    :error-message="form.errors.name"
                                    :error="form.errors.name ? true : false"
                                />
                                <q-input
                                    clearable
                                    filled
                                    v-model="form.email"
                                    :label="$t('g.login_email')"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    type="email"
                                    :error-message="form.errors.email"
                                    :error="form.errors.email ? true : false"
                                />
                                <q-input
                                    clearable
                                    filled
                                    v-model="form.phone"
                                    :label="$t('g.phone_number')"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    type="phone"
                                    :error-message="form.errors.phone"
                                    :error="form.errors.phone ? true : false"
                                />
                            </div>
                        </template>

                        <template v-slot:separator>
                            <q-avatar
                                color="primary"
                                text-color="white"
                                size="20px"
                                icon="drag_indicator"
                            />
                        </template>

                        <template v-slot:after>
                            <div class="q-pa-sm">
                                <q-input
                                    filled
                                    clearable
                                    v-model="form.password"
                                    :label="$t('g.login_password')"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    type="password"
                                    :error-message="form.errors.password"
                                    :error="form.errors.password ? true : false"
                                />
                                <q-input
                                    clearable
                                    filled
                                    v-model="form.password_confirmation"
                                    :label="$t('g.login_password_confirmation')"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    type="password"
                                />

                                <div class="row">
                                    <div class="col q-mr-sm">
                                        <q-select
                                            clearable
                                            filled
                                            v-model="form.role_id"
                                            :options="roles"
                                            :label="$t('input.user.role')"
                                            option-value="id"
                                            option-label="title"
                                            :rules="[
                                                (val) =>
                                                    val != null ||
                                                    $t('v.selected'),
                                            ]"
                                            emit-value
                                            map-options
                                            :error-message="form.errors.role_id"
                                            :error="
                                                form.errors.role_id
                                                    ? true
                                                    : false
                                            "
                                        />
                                    </div>
                                    <div class="col q-ml-sm">
                                        <q-select
                                            clearable
                                            filled
                                            v-model="form.status"
                                            :options="[1, 2, 3, 4, 5, 6]"
                                            :option-label="
                                                (opt) =>
                                                    $t(
                                                        'input.list.' +
                                                            opt
                                                    )
                                            "
                                            :label="$t('input.user.job')"
                                            :rules="[
                                                (val) =>
                                                    val != null ||
                                                    $t('v.selected'),
                                            ]"
                                            :error="form.errors.role_id"
                                        >

                                        </q-select>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </q-splitter>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.save')"
                        type="submit"
                        color="primary"
                        :loading="setting.loading"
                    />
                    <q-btn
                        :label="$t('g.reset')"
                        type="reset"
                        color="warning"
                        flat
                        class="q-ml-sm"
                    />
                    <!-- <q-btn
                        flat
                        :label="$t('g.close')"
                        v-close-popup
                        color="negative"
                    /> -->
                </q-card-actions>
            </q-form>
        </q-card>
    </q-page>
</template>

<script setup>
import { useForms } from "../../Composables/rules";
import { useForm, router } from "@inertiajs/vue3";
import { useSettings } from "@/stores/settings";
import Layout from "../../Layouts/AppLayout.vue";
defineOptions({ layout: Layout });
const setting = useSettings();
setting.title = "input.user.title";
setting.supTitle = "input.user.title_new";
setting.icon = "mdi-account-multiple";
setting.supIcon = "person_add";

const { rules: rulesData } = useForms();
const rules = rulesData;
defineProps(["roles"]);

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    phone: "",
    details: "",
    role_id: null,
    status : 6
});

const onSubmit = () => {
    form.post(route("users.store"), {
        preserveState: true,
        onFinish: () => form.reset("password", "password_confirmation"),
    });

    console.log(form.errors);
};

const onReset = () => {
    form.reset();
};
</script>

<style></style>
