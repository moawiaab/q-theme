<template>
    <q-item
        clickable
        :active="
            data.to.includes(route().current().split('.')[0]) ? true : false
        "
        dense
        active-class="my-menu-link"
        @click="setRoute(data.to)"
        :id="data.to"
    >
        <Link
            :href="route(data.to)"
            class="q-item row no-wrap q-link full-width q-px-xs"
        >
            <q-item-section avatar>
                <q-icon :name="data.icon || 'explore'" />
            </q-item-section>

            <q-item-section>
                {{ $t(data.text) }}
            </q-item-section>
        </Link>
    </q-item>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
defineProps(["data", "id"]);

const setRoute = (e) => {
    const eall = document.getElementsByClassName(
        "q-item q-item-type row no-wrap"
    );
    for (let index = 0; index < eall.length; index++) {
        eall[index].classList.remove("q-item--active");
        eall[index].classList.remove("my-menu-link");
    }
    const el = document.getElementById(e);
    el.classList.add("q-item--active");
    el.classList.add("my-menu-link");
};
</script>

<style lang="sass">
.my-menu-link
  color: white
  background: #31CCEC
</style>
