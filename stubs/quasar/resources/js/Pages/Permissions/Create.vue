<template>
    <q-page padding>
        <h-title :title="$t('input.permission.title_new')" />

        <q-card class="q-px-sm" flat >
            <q-card-section>
                <div class="text-h6">{{ $t("input.permission.title_new") }}</div>
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

                    <div class="row">
                        <div class="col">
                            <q-list separator>
                                <q-item>
                                    <q-item-label>{{$t('input.permission.name')}}</q-item-label>
                                </q-item>
                                <q-item v-for="i in permission.details" :key="i"> {{i + form.details}}</q-item>
                            </q-list>
                        </div>
                        <q-separator vertical/>
                        <div class="col">
                            <q-list separator>
                                <q-item>
                                    <q-item-label>{{$t('input.permission.role')}}</q-item-label>
                                </q-item>
                                    <q-item v-for="i in permission.title" :key="i"> {{form.title + i}}</q-item>
                            </q-list>
                        </div>
                    </div>
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
import { usePermissionsIndex } from "../../stores/permissions/index";
const permission = usePermissionsIndex();
import Layout from "../../Layouts/AppLayout.vue";
defineOptions({ layout: Layout });
const setting = useSettings();
setting.title = "input.permission.title";
setting.supTitle = "input.permission.title_new";
setting.icon = "mdi-link-lock";
setting.supIcon = "mdi-lock";

const { rules: rulesData } = useForms();
const rules = rulesData;
defineProps(["roles"]);

const form = useForm({
    title: "",
    details: "",
});

const onSubmit = () => {
    form.post(route("permissions.store"), {
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
