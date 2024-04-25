<script lang="ts" setup>
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    links: { type: Array },
});
</script>

<template>
    <div class="q-pa-xs flex flex-center q-gutter-xs">
        <Link
            v-for="item in links.links"
            :key="item.label"
            :href="item.url"
            class="q-gutter-xs"
        >
            <q-btn
                v-if="item.label.includes('Previous')"
                size="sm"
                round
                icon="fast_forward"
                :color="item.url ? 'primary' : 'grey'"
                :disable="item.url == null ? true : false"
            />
            <q-btn
                v-else-if="item.label.includes('Next')"
                size="sm"
                round
                icon="fast_rewind"
                :color="item.url ? 'primary' : 'grey'"
                :disable="item.url == null ? true : false"
            />
            <q-btn
                v-else
                size="sm"
                round
                :color="item.active ? 'primary' : 'grey-4 text-blue text-bold'"
                :label="item.label"
                :disable="item.active? true : false"
            />
        </Link>

    </div>
</template>

<style scoped></style>
