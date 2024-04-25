<template>
    <q-page padding>
         <h-title :title="$t('input.permission.title_edit')"/>
        <q-card class="q-px-sm" flat>
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.permission.title_edit") }} :
                    {{ form.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">

                <q-card-section class="q-p-sm">
                    <q-input
                        clearable
                        filled
                        v-model="form.details"
                        :label="$t('input.permission.name')"
                        lazy-rules
                        :rules="[(val) => !!val || $t('v.required')]"
                    />
                    <q-input
                        clearable
                        filled
                        v-model="form.title"
                        :label="$t('input.permission.url')"
                        lazy-rules
                        :rules="[(val) => !!val || $t('v.required')]"
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
settings.title = "input.permission.title";
settings.supTitle = "input.permission.title_edit";
settings.icon = "mdi-account-multiple";

const { rules: rulesData } = useForms();
const rules = rulesData;
const props = defineProps(["permission"]);

const form = useForm(props.permission);
import Layout from "../../Layouts/AppLayout.vue";
defineOptions({ layout: Layout });
const onSubmit = () => {
    form.put(route("permissions.update", form.id), {
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
