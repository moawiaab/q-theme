<template>
    <template v-for="(item, index) in items" :key="index">
        <list-item
            v-if="
                item.children &&
                $page.props.can.includes(`${item.access}_access`)
            "
            :label="$t(item.text)"
            :icon="item.icon"
            :default-opened="item.to.includes(route().current().split('.')[0])"
        >
            <!-- item.to.includes($route.path) -->
            <template v-for="(i, id) in item.children" :key="id">
                <item
                    v-if="$page.props.can.includes(`${i.access}_access`)"
                    :data="i"
                />
            </template>
        </list-item>
        <template v-else>
            <item
                v-if="$page.props.can.includes(`${item.access}_access`)"
                :data="item"
            />
        </template>
    </template>
</template>

<script setup>
import Item from "./Item.vue";
import ListItem from "./ListItem.vue";

const items = [
    {
        text: "g.dashboard",
        icon: "mdi-home-outline",
        to: "dashboard",
        access: "dashboard",
    },

    {
        text: "item.user_management",
        icon: "mdi-account-cog-outline",
        to: ["users", "roles", "permissions"],
        access: "user_management",
        children: [
            {
                text: "item.user",
                icon: "mdi-account-details-outline",
                to: "users.index",
                access: "user",
                active: "users",
            },
            {
                text: "item.role",
                icon: "mdi-account-lock-outline",
                to: "roles.index",
                access: "role",
                active: "roles",
            },
            {
                text: "item.permission",
                icon: "mdi-lock-outline",
                to: "permissions.index",
                access: "permission",
                active: "permissions",
            },
        ],
    },

];
</script>
