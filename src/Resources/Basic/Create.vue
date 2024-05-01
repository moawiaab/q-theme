<template>
  <q-page padding>
    <h-title :title="$t('input.user.title_new')" />

    <q-card class="q-px-sm" flat>
      <q-card-section>
        <div class="text-h6">{{ $t("input.user.title_new") }}</div>
      </q-card-section>
      <q-separator />
      <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
        <q-card-section class="q-pt-none">
          <q-splitter v-model="setting.splitterModel" style="height: 100%">
            <template v-slot:before>
              <div class="q-pa-sm">
                <q-input
                  clearable
                  filled
                  v-model="form.name"
                  :label="$t('g.name')"
                  lazy-rules
                  :rules="[(val) => !!val || $t('v.required')]"
                  :error-message="form.errors.name"
                  :error="form.errors.name ? true : false"
                />
              </div>
            </template>

            <template v-slot:separator>
              <q-avatar
                color="primary"
                text-color="white"
                size="20px"
                icon="drag_indicator"
              />
            </template>

            <template v-slot:after>
              <div class="q-pa-sm"></div>
            </template>
          </q-splitter>
        </q-card-section>
        <q-separator />
        <q-card-actions align="right" class="bg-white text-teal">
          <q-btn
            flat
            :label="$t('g.save')"
            type="submit"
            color="primary"
            :loading="setting.loading"
          />
          <q-btn
            :label="$t('g.reset')"
            type="reset"
            color="warning"
            flat
            class="q-ml-sm"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-page>
</template>

<script setup>
import { useForms } from "../../Composables/rules";
import { useForm } from "@inertiajs/vue3";
import { useSettings } from "@/stores/settings";
import Layout from "../../Layouts/AppLayout.vue";
defineOptions({ layout: Layout });
const setting = useSettings();
setting.title = "input.user.title";
setting.supTitle = "input.user.title_new";
setting.icon = "mdi-account-multiple";
setting.supIcon = "person_add";

const { rules: rulesData } = useForms();
const rules = rulesData;
//defineProps(["roles"]);

const form = useForm({
  name: "",
});

const onSubmit = () => {
  form.post(route("users.store"), {
    preserveState: true,
    onFinish: () => form.reset(),
  });

  console.log(form.errors);
};

const onReset = () => {
  form.reset();
};
</script>

<style></style>
