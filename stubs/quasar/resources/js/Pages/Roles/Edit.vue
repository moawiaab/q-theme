<template>
    <q-page padding>
        <h-title :title="$t('input.role.title_edit')" />
        <q-card class="q-px-sm" flat>
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.role.title_edit") }} :
                    {{ form.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-p-sm">
                    <q-input
                        clearable
                        filled
                        v-model="form.title"
                        :label="$t('input.role.name')"
                        lazy-rules
                        :rules="[(val) => !!val || $t('v.required')]"
                    />

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
                    <q-btn
                        flat
                        :label="$t('g.close')"
                        v-close-popup
                        color="negative"
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

const settings = useSettings();
settings.title = "input.user.title";
settings.supTitle = "input.user.title_edit";
settings.icon = "mdi-source-branch";
import Layout from "../../Layouts/AppLayout.vue";
defineOptions({ layout: Layout });
const { rules: rulesData } = useForms();
const rules = rulesData;
const props = defineProps(["role", "permissions"]);

const form = useForm(props.role);

const onSubmit = () => {
    form.put(route("roles.update", form.id), {
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
