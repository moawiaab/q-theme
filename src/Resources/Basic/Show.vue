<template>
    <q-page padding>
        <h-title :title="$t('input.user.view')" />
        <q-card flat>
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.user.view") }} :
                    {{ user.data.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-card-section class="q-pt-none">
                <q-splitter
                    v-model="settings.splitterModel"
                    style="height: 100%"
                >
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-list>
                                <q-item>
                                    <q-item-label
                                        >{{ $t("g.user_name") }} :
                                        {{ user.data.name }}</q-item-label
                                    >
                                </q-item>
                            </q-list>
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
                        <div class="q-pa-sm">details</div>
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
settings.title = "input.user.title";
settings.supTitle = "input.user.view";
settings.icon = "mdi-account-multiple"
settings.supIcon = "visibility"
defineProps(["user"]);
</script>

<style></style>
