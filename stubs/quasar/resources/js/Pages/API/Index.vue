<script setup>
import ApiTokenManager from '@/Pages/API/Partials/ApiTokenManager.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
defineOptions({
    layout: AppLayout,
});
defineProps({
    tokens: Array,
    availablePermissions: Array,
    defaultPermissions: Array,
});
</script>

<template>
   <q-page padding >
    <ApiTokenManager/>
   </q-page>
</template>
