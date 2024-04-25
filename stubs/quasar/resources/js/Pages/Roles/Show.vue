<template>
    <q-page padding>
        <h-title :title="$t('input.role.view')" />
        <q-card flat>
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.role.view") }} :
                    {{ role.data.title }}
                </div>
            </q-card-section>
            <q-separator />
            <q-card-section class="q-pt-none">
                <div class="q-pa-sm">
                    <q-list>
                        <q-item>
                            <q-item-label>
                                {{ $t("input.role.name") }} :
                                {{ role.data.title }}</q-item-label
                            >
                        </q-item>
                        <q-separator inset />

                        <q-separator inset />
                        <q-item>
                            <q-item-label
                                >تاريخ الانشاء :
                                {{ role.data.created_at }}</q-item-label
                            >
                        </q-item>
                        <q-separator inset />
                    </q-list>
                </div>
                <q-splitter
                    v-model="settings.splitterModel"
                    style="height: 100%"
                >
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-card-section>
                                {{ $t("input.role.role") }}
                            </q-card-section>

                            <div class="row">
                                <q-chip
                                    icon="link"
                                    color="red-1"
                                    text-color="red"
                                    square
                                    class="col-auto glossy"
                                    v-for="{ id, name } in permissions"
                                    :key="id"
                                >
                                    {{ name }}</q-chip
                                >
                            </div>
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
                            <q-card-section>
                                {{ $t("input.role.user") }}
                            </q-card-section>

                            <div class="row">
                                <q-chip
                                    icon="person"
                                    color="blue-1"
                                    text-color="blue"
                                    square
                                    class="col-auto glossy"
                                    v-for="{ id, name } in users"
                                    :key="id"
                                >
                                    {{ name }}</q-chip
                                >
                            </div>
                        </div>
                    </template>
                </q-splitter>
            </q-card-section>
            <q-separator />
        </q-card>
    </q-page>
</template>

<script setup>
import { useSettings } from "@/stores/settings";
import Layout from "../../Layouts/AppLayout.vue";
defineOptions({ layout: Layout });
const settings = useSettings();
settings.title = "input.role.title";
settings.supTitle = "input.role.view";
settings.icon = "mdi-source-branch";
settings.supIcon = "visibility"
defineProps(["role", "permissions", "users"]);
</script>

<style></style>
