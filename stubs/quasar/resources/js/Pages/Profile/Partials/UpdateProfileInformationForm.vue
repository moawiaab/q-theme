<script setup>
import { ref } from "vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import HCard from "@/Components/Widgets/HCard.vue";

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: "PUT",
    name: props.user.name,
    email: props.user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route("current-user-photo.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <h-card icon="person" :title="$t('input.profile.t1')">
        <template #caption>{{ $t("input.profile.d1") }}</template>
        <q-form
            @submit="updateProfileInformation"
            @reset="onReset"
            class="q-gutter-md"
        >
            <q-input
                clearable
                filled
                v-model="form.name"
                :label="$t('g.user_name')"
                lazy-rules
                :rules="[(val) => !!val || $t('v.required')]"
                :error-message="form.errors.name"
                :error="form.errors.name ? true : false"
            />
            <q-input
                clearable
                filled
                v-model="form.email"
                :label="$t('g.login_email')"
                lazy-rules
                :rules="[(val) => !!val || $t('v.required')]"
                type="email"
                :error-message="form.errors.email"
                :error="form.errors.email ? true : false"
            />
            <q-btn
                flat
                :label="$t('g.save')"
                type="submit"
                color="primary"
                :loading="form.loading"
            />

            <a-message :on="form.recentlySuccessful" class="me-3">
                {{ $t("g.update_profile_success") }}
            </a-message>
        </q-form>
        <template #details>
            <div v-show="!photoPreview" class="text-center">
                <q-img
                    :src="user.profile_photo_url"
                    :alt="user.name"
                    style="
                        max-height: 200px;
                        max-width: 200px;
                        border-radius: 20px;
                    "
                />
            </div>
        </template>
    </h-card>
</template>
