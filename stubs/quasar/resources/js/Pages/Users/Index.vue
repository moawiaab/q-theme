<script setup>
import { Users } from "@/types/columns";
import { useSettings } from "@/stores/settings";
import Layout from "../../Layouts/AppLayout.vue";
defineOptions({ layout: Layout });
const setting = useSettings();
setting.title = "input.user.title";
setting.supTitle = "";
setting.icon = "mdi-account-multiple";

defineProps({
    users: Object,
});
</script>
<template>
    <q-page>
        <loading v-if="users" />
        <h-title :title="$t('input.user.title')" />
        <data-table
            :columns="Users"
            :rows="users"
            url="users"
            viewable
            creatable
            role="user"
            :newRow="$page.props.can.includes(`user_create`)"
        >
            <template #body-cell-status="props">
                <q-td :items="props.row">
                    {{ $t('input.list.'+props.items.row.status) }}
                </q-td>
            </template>
        </data-table>
        <!-- <create-user :roles="roles" /> -->
    </q-page>
</template>
