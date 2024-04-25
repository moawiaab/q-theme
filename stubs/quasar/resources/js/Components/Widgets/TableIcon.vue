<template>
        <Link
            :href="route(url, pram)"
            class=""
        >
            <q-btn glossy :icon="icon" dense flat rounded :color="color" />
        </Link>
</template>
<script setup>
import { router, Link } from "@inertiajs/vue3";
defineProps({
    url : {type: String},
    icon : {type: String, default: "edit"},
    color : {type: String, default: "info"},
    pram : {type: Number, default: 0}
})
</script>
