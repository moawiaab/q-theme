<template>
    <q-expansion-item
        group="somegroup"
        icon="explore"
        label="First"
        expand-icon="arrow_drop_down"
        active-class="text-blue"
        :content-inset-level="0.1"
        expand-separator
        :class="my_class"
        @before-show="my_class = 'active-class'"
        @after-hide="my_class = null"
    >
        <q-list separator>
            <slot />
        </q-list>
    </q-expansion-item>
</template>
<script setup>
import { ref } from "vue";
const my_class = ref();
</script>

<style scoped>
.active-class {
    color: #78948b;
}
</style>
