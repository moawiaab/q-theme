<template>
    <q-page padding>
        <loader v-if="setting.loading" />
        <h-title :title="$t('input.role.title_new')" />

        <q-card class="q-px-sm" flat>
            <q-card-section>
                <div class="text-h6">{{ $t("input.role.title_new") }}</div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-p-sm">
                    <q-input
                        filled
                        clearable
                        lazy-rules
                        v-model="form.title"
                        :label="$t('input.role.name')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :error="form.errors.title ? true : false"
                        :error-message="form.errors.title"
                    >
                        <template #append>
                            <q-icon name="person" />
                        </template>
                    </q-input>

                    <q-select
                        use-chips
                        multiple
                        clearable
                        filled
                        v-model="form.permissions"
                        :options="permissions"
                        :label="$t('item.role')"
                        option-value="value"
                        option-label="label"
                        :rules="[(val) => val != null || $t('v.selected')]"
                        emit-value
                        map-options
                    />
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
                </q-card-actions>
            </q-form>
        </q-card>
    </q-page>
</template>

<script setup>
import { useForms } from "../../Composables/rules";
import { useForm, router } from "@inertiajs/vue3";
import { useSettings } from "@/stores/settings";

const setting = useSettings();
setting.title = "input.role.title";
setting.supTitle = "input.role.title_new";
setting.icon = "mdi-account-lock-outline"
setting.supIcon = "add";

const { rules: rulesData } = useForms();
const rules = rulesData;
defineProps(["permissions"]);
import Layout from "../../Layouts/AppLayout.vue";
defineOptions({ layout: Layout });
const form = useForm({
    title: "",
    permissions: [],
});

const onSubmit = () => {
    form.post(route("roles.store"), {
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
