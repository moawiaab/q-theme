<script setup>
defineProps(["title", "icon"]);
</script>
<template>
    <q-card class="my-card" flat bordered>
        <q-item>
            <q-item-section avatar>
                <q-avatar>
                    <q-icon :name="icon || 'home'" />
                </q-avatar>
            </q-item-section>

            <q-item-section>
                <q-item-label>
                    {{ title }}
                </q-item-label>
                <q-item-label caption> <slot name="caption" /> </q-item-label>
            </q-item-section>
        </q-item>

        <q-separator />

        <q-card-section :horizontal="$q.screen.width >= 650 ? true : false">
            <q-card-section class="col-8">
                <slot />
            </q-card-section>

            <q-separator vertical />

            <q-card-section class="col-4">
                <slot name="details" />
            </q-card-section>
        </q-card-section>
    </q-card>
</template>
