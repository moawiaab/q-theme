<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import { useForms } from "../../Composables/rules";
import { useForm } from "@inertiajs/vue3";

defineProps(["controllers", "models", "resources", "requests"]);
defineOptions({
    layout: AppLayout,
});
const splitterModel = ref(30);

const { rules: rulesData } = useForms();
const rules = rulesData;
const form = useForm({
    controller: "",
    model: true,
    resource: false,
    request: false,
});

const onSubmit = () => {
    form.post(route("development.store"), {
        preserveState: true,
        onFinish: () => form.reset("password", "password_confirmation"),
    });

    console.log(form.errors);
};

const onReset = () => {
    form.reset();
};
</script>

<template>
    <q-page padding>
        <q-splitter
            v-model="splitterModel"
            style="height: 100%"
            :limits="[50, 60]"
        >
            <template v-slot:before>
                <q-separator />
                <q-card class="q-mb-sm">
                    <q-card-section class="text-h4"
                        >Controllers
                        <q-badge align="top" color="blue">{{
                            controllers.length
                        }}</q-badge>
                    </q-card-section>
                    <q-separator />
                    <q-card-section>
                        <q-chip
                            square
                            color="blue-2"
                            text-color="blue"
                            v-for="(item, i) in controllers"
                            :key="i"
                            >{{ item }}</q-chip
                        >
                    </q-card-section>
                </q-card>

                <q-card class="q-mb-sm">
                    <q-card-section class="text-h4"
                        >Models
                        <q-badge align="top" color="red">{{
                            models.length
                        }}</q-badge>
                    </q-card-section>
                    <q-separator />
                    <q-card-section>
                        <q-chip
                            square
                            color="red-2"
                            text-color="red"
                            v-for="(item, i) in models"
                            :key="i"
                            >{{ item }}</q-chip
                        >
                    </q-card-section>
                </q-card>

                <q-card class="q-mb-sm">
                    <q-card-section class="text-h4"
                        >Resources
                        <q-badge color="green" align="top">{{
                            resources.length
                        }}</q-badge>
                    </q-card-section>
                    <q-separator />
                    <q-card-section>
                        <q-chip
                            square
                            color="green-2"
                            text-color="green"
                            v-for="(item, i) in resources"
                            :key="i"
                            >{{ item }}</q-chip
                        >
                    </q-card-section>
                </q-card>

                <q-card class="q-mb-sm">
                    <q-card-section class="text-h4"
                        >Requests
                        <q-badge color="grey" align="top">{{
                            requests.length
                        }}</q-badge>
                    </q-card-section>
                    <q-separator />
                    <q-card-section>
                        <q-chip square v-for="(item, i) in requests" :key="i">{{
                            item
                        }}</q-chip>
                    </q-card-section>
                </q-card>
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
                <div class="q-ma-md">
                    <q-form
                        @submit="onSubmit"
                        @reset="onReset"
                        class="q-gutter-md"
                    >
                        <q-input
                            clearable
                            filled
                            v-model="form.controller"
                            label="Controller Name"
                            hint="If You Like Set UserController Entre User Only"
                            lazy-rules
                            :rules="[(val) => !!val || $t('v.required')]"
                            :error-message="form.errors.controller"
                            :error="form.errors.controller ? true : false"
                        />
                        <div class="text-gary">
                            1- Controller , 2- Model , 3- Resource , 4- Require
                        </div>

                        <q-separator />

                        <q-item dense>
                            <q-checkbox
                                keep-color
                                v-model="form.model"
                                label="Set Model To this Controller"
                                color="red"
                            />
                        </q-item>

                        <q-item dense>
                            <q-checkbox
                                keep-color
                                v-model="form.resource"
                                label="Set Resource To this Controller"
                                color="green"
                            />
                        </q-item>

                        <q-item dense>
                            <q-checkbox
                                keep-color
                                v-model="form.request"
                                label="Set Request To this Controller"
                                color="info"
                            />
                        </q-item>

                        <q-separator />
                        <q-btn
                            class="full-width"
                            :label="$t('g.save')"
                            type="submit"
                            color="primary"
                            :loading="form.loading"
                        />
                    </q-form>
                </div>
            </template>
        </q-splitter>
    </q-page>
</template>
