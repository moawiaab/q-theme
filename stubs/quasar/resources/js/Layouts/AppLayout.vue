<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import ListMenu from "@/Components/menu/ListMenu.vue";
import MenuIcon from "@/Components/menu/icon.vue";
import { useSettings } from "@/stores/settings";

const setting = useSettings();
const logout = () => {
    router.post(route("logout"));
};
const drawerLeft = ref(false);
</script>

<template>
    <q-layout view="lHh LpR rff" container style="height: 100vh">
        <q-header class="q-py-xs bg-white text-black inset-shadow-down">
            <q-toolbar>
                <q-btn
                    flat
                    @click="drawerLeft = !drawerLeft"
                    round
                    dense
                    icon="menu"
                />
                <q-toolbar-title>
                    <q-breadcrumbs class="text-brown">
                        <template v-slot:separator>
                            <q-icon
                                size="1.5em"
                                name="chevron_right"
                                color="primary"
                            />
                        </template>

                        <v-link :href="route('dashboard')">
                            <q-breadcrumbs-el
                                :label="$t('app_title')"
                                icon="home"
                            />
                        </v-link>
                        <q-breadcrumbs-el
                            v-if="setting.title"
                            :label="$t(setting.title)"
                            :icon="setting.icon"
                        />
                        <q-breadcrumbs-el
                            v-if="setting.supTitle"
                            :label="$t(setting.supTitle)"
                            :icon="setting.supIcon"
                        />
                    </q-breadcrumbs>
                </q-toolbar-title>
                <q-btn
                    flat
                    icon="mdi-translate"
                    dense
                    fab-mini
                    @click="
                        setting.chingLang();
                        $i18n.locale = setting.quasarLang;
                    "
                />
                <q-btn flat icon="notifications" dense fab-mini />

                <q-btn flat dense fab-mini round>
                    <q-avatar>
                        <q-img
                            :src="$page.props.user.profile_photo_url"
                            :alt="$page.props.user.name"
                        />
                    </q-avatar>
                    <q-menu transition-show="rotate" transition-hide="rotate">
                        <q-list style="min-width: 200px" separator>
                            <v-link
                                :href="route('profile.show')"
                                class="no-wrap q-link full-width"
                            >
                                <menu-icon
                                    text="g.m.profile"
                                    icon="mdi-account"
                                    to="/about"
                                    color="blue"
                                />
                            </v-link>
                            <menu-icon
                                text="g.m.password"
                                icon="password"
                                @click="settings.password = true"
                                v-close-popup
                            />
                            <menu-icon
                                text="g.m.setting"
                                icon="settings"
                                color="green"
                                to="/settings"
                            />
                            <menu-icon
                                text="g.logout"
                                icon="logout"
                                color="red"
                                @click="logout()"
                            />
                        </q-list>
                    </q-menu>
                </q-btn>
                <!-- <q-btn
                    flat
                    @click="logout()"
                    round
                    dense
                    icon="logout"
                    color="red"
                /> -->
            </q-toolbar>
        </q-header>

        <q-drawer
            v-model="drawerLeft"
            :width="260"
            :breakpoint="700"
            bordered
            show-if-above
        >
            <div
                class="row justify-center q-px-md q-pt-md fixed-top"
                style="z-index: 8; height: 192px"
                v-if="$page.props.jetstream.managesProfilePhotos"
            >
                <q-avatar size="100px" style="border: 2px solid white">
                    <q-img
                        :src="$page.props.user.profile_photo_url"
                        :alt="$page.props.user.name"
                        fit="cover"
                        width="100%"
                        height="100%"
                    />
                </q-avatar>
                <q-item class="q-pt-sm" dense>
                    <v-link
                        :href="route('profile.show')"
                        class="q-item row no-wrap q-link full-width q-px-xs"
                    >
                        <q-item-section class="q-pa-sm">
                            <q-item-label>
                                مرحباً :
                                {{ $page.props.user.name }}</q-item-label
                            >
                            <q-item-label caption>
                                <q-item-section>
                                    البريد : {{ $page.props.user.email }}
                                </q-item-section>
                            </q-item-label>
                        </q-item-section>
                    </v-link>
                </q-item>
            </div>
            <q-separator />
            <!-- <q-scroll-area class="fit"> -->
            <q-list separator class="q-mb-xl" style="padding-top: 192px">
                <list-menu />
            </q-list>
            <!-- </q-scroll-area> -->
            <q-item
                v-ripple
                class="text-red footer full-width fixed-bottom"
                clickable
                @click="logout()"
            >
                <q-item-section avatar>
                    <q-icon name="logout" />
                </q-item-section>

                <q-item-section> تسجيل خروج </q-item-section>
            </q-item>
        </q-drawer>

        <q-page-container>
            <main
                :key="$page.url"
                class="container p-4 mx-auto mt-[60px] relative"
            >
                <slot />
            </main>

            <q-page-scroller position="bottom-right">
                <q-btn
                    fab
                    icon="keyboard_arrow_up"
                    color="teal"
                    class="glossy"
                />
            </q-page-scroller>
        </q-page-container>
    </q-layout>
</template>
