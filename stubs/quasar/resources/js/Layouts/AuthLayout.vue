<script setup>
import { Quasar } from "quasar";
import ar from "quasar/lang/ar";
import en from "quasar/lang/en-US";
import { ref } from "vue";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    auth: Object,
});

const quasarLang = ref();
const chingLang = () => {
    if (quasarLang.value === "en-US") {
        quasarLang.value = "ar";
        Quasar.lang.set(ar);
    } else if (quasarLang.value === "ar") {
        quasarLang.value = "en-US";
        Quasar.lang.set(en);
    } else {
        quasarLang.value = "en-US";
        Quasar.lang.set(en);
    }
};
</script>
<template>
    <!-- <div class=""> -->
    <q-layout
        view="lhh LpR lff"
        container
        style="height: 100vh"
        class="text-black"
    >
        <q-header class="q-py-xs bg-white">
            <q-toolbar class="">
                <div class="">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="q-item row no-wrap q-link full-width q-px-xs"
                    >
                        {{ $t("g.dashboard") }}
                    </Link>
                    <template v-else>
                        <Link :href="route('login')" class="q-item q-link">{{
                            $t("g.login")
                        }}</Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="q-item q-link"
                            >{{ $t("g.create_account") }}</Link
                        >
                    </template>
                </div>

                <q-space />

                <q-btn
                    flat
                    icon="mdi-translate"
                    dense
                    fab-mini
                    @click="
                        chingLang();
                        $i18n.locale = quasarLang;
                    "
                />
                <q-btn
                    flat
                    icon="notifications"
                    dense
                    fab-mini
                    v-if="canLogin"
                />
            </q-toolbar>
        </q-header>

        <q-page-container>
            <slot />
        </q-page-container>
    </q-layout>
    <!-- </div> -->
</template>

<style lang="scss">
.q-item.row.no-wrap.q-link.q-px-xs {
    align-items: center;
}
</style>
