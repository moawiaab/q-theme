<script setup>
import { Permissions } from "@/types/columns";
import { useSettings } from "@/stores/settings";
const setting = useSettings();
import Layout from "../../Layouts/AppLayout.vue";
defineOptions({ layout: Layout });
setting.title = "input.permission.title"
setting.supTitle = ""
setting.icon = "mdi-link-lock";

defineProps({
    permissions: Object,
});
</script>
<template>
    <q-page>
        <h-title :title="$t('input.permission.title')"/>
        <data-table
            :columns="Permissions"
            :rows="permissions"
            url="permissions"
            :viewable="false"
            creatable
            role="permission"
            :newRow="$page.props.can.includes(`permission_create`)"
        >
        </data-table>
<!-- <create-permission :roles="roles" /> -->
    </q-page>
</template>
