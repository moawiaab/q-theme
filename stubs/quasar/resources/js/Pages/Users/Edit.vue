<template>
    <q-page padding>
         <h-title :title="$t('input.user.title_edit')"/>
        <q-card class="q-px-sm" flat>
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.user.title_edit") }} :
                    {{ form.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <q-splitter
                        v-model="settings.splitterModel"
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
                        :label="$t('g.update')"
                        type="submit"
                        color="primary"
                        :loading="settings.loading"
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
                        :label="$t('g.back')"
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

const settings = useSettings();
settings.title = "input.user.title";
settings.supTitle = "input.user.title_edit";
settings.icon = "mdi-account-multiple";
import Layout from "../../Layouts/AppLayout.vue";
defineOptions({ layout: Layout });
const { rules: rulesData } = useForms();
const rules = rulesData;
const props = defineProps(["roles", "user"]);

const form = useForm(props.user);

const onSubmit = () => {
    form.put(route("users.update", form.id), {
        preserveState: true,
        onFinish: () => {
            form.reset("password", "password_confirmation");
            settings.loading = false;
        },
        onStart: () => (settings.loading = true),
    });

    console.log(form.errors);
};

const onReset = () => {
    form.reset();
};
</script>

<style></style>
