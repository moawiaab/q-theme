<script setup>
import { Roles } from "@/types/columns";
import { router } from "@inertiajs/vue3";
import { useSettings } from "@/stores/settings";
import Layout from "../../Layouts/AppLayout.vue";
defineOptions({ layout: Layout });
const setting = useSettings();
setting.title = "input.role.title";
setting.icon = "mdi-account-lock-outline"


defineProps({
    roles: Object,
});
</script>
<template>
    <q-page>
        <h-title :title="$t('input.role.title')" />
        <data-table
            :columns="Roles"
            :rows="roles"
            url="roles"
            viewable
            creatable
            expand
            role="role"
            :newRow="$page.props.can.includes(`role_create`)"
        >
            <template #table-body="{ props }">
                <q-splitter v-model="setting.splitterModel" style="height: 100%">
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
                                    v-for="{ id, details } in props.row
                                        .permissions"
                                    :key="id"
                                >
                                    {{ details }}</q-chip
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
                                    v-for="{ id, name } in props.row.users"
                                    :key="id"
                                >
                                    {{ name }}</q-chip
                                >
                            </div>
                        </div>
                    </template>
                </q-splitter>
            </template>
        </data-table>
    </q-page>
</template>
