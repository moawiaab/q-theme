<script setup>
import HCard from "@/Components/Widgets/HCard.vue";
// import AppLayout from '@/Layouts/AppLayout.vue';
// import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
// import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
// import SectionBorder from '@/Components/SectionBorder.vue';
import TwoFactorAuthenticationForm from "@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import Layout from "@/Layouts/AppLayout.vue";
defineOptions({ layout: Layout });

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <q-page padding>
        <template v-if="$page.props.jetstream.canUpdateProfileInformation">
            <UpdateProfileInformationForm :user="$page.props.auth.user" />
        </template>

        <div v-if="$page.props.jetstream.canUpdatePassword">
            <UpdatePasswordForm />
        </div>

        <!-- <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
            <TwoFactorAuthenticationForm
                :requires-confirmation="confirmsTwoFactorAuthentication"
                class="mt-10 sm:mt-0"
            />
        </div> -->
    </q-page>
</template>
