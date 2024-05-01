<script setup>
import { UsersColumn } from "@/types/columns";
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
            :columns="UsersColumn"
            :rows="users"
            url="users"
            viewable
            creatable
            role="user"
            :newRow="$page.props.can.includes(`user_create`)"
        >

        </data-table>
    </q-page>
</template>
