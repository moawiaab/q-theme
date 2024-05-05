<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ECard from "@/Components/Widgets/ECard.vue";
import OneForm from "@/Components/form/OneForm.vue";
import TableForm from "./TableForm.vue";
import { ref } from "vue";
import { useForms } from "../../Composables/rules";
import { useForm } from "@inertiajs/vue3";
import { Notify } from "quasar";

defineProps(["controllers", "models", "resources", "requests", "tables"]);
defineOptions({
    layout: AppLayout,
});
const splitterModel = ref(30);
const tab = ref("controller");
const item = ref({
    name: null,
    type: "text",
    filed: "",
    require: false,
    num: null,
    value: null,
    belongsTo: null,
});

const selectType = ref("text");
const belongsTo = ref(false);
const { rules: rulesData } = useForms();
const rules = rulesData;
const form = useForm({
    controller: "",
    items: [],
    tab: "controller",
});

const onSubmit = () => {
    form.post(route("development.store"), {
        preserveState: true,
        onFinish: () => form.reset(),
        onSuccess: () => Notify.create("Create Successfully", {
            color: 'secondary'
        }),
    });

    console.log(form.errors);
};

const submittedData = () => {
    form.post(route("development.storeModel"), {
        preserveState: true,
        onFinish: () => form.reset(),
        onSuccess: () => Notify.create("Create Successfully", {
            color: 'secondary'
        }),
    });

    console.log(form.errors);
};

const addItem = () => {
    if (item.value.name != null && item.value.name.length > 1) {
        form.items.push({
            ...item.value,
            filed: item.value.name,
        });
        item.value = {
            name: null,
            type: "text",
            filed: "",
            require: false,
            value: null,
            belongsTo: null,
        };
    } else {
        Notify.create("Set Column Name ");
    }
};

const onReset = () => {
    form.reset();
};

const columns = [
    { name: "name", align: "left", label: "Column Name", field: "name" },
    { name: "filed", align: "center", label: "Filed Name", field: "filed" },
    { name: "type", label: "Filed Type", field: "type" },
    { name: "value", label: "Default Value", field: "value" },
    { name: "require", label: "Require", field: "require" },
];
const options = [
    "text",
    "integer",
    "decimal",
    "tinyText",
    "longText",
    "tinyInteger",
    "smallInteger",
    "bigInteger",
    "double",
    "boolean",
    "date",
    "phone",
    "belongsTo",
];

const setType = (type) => {
    belongsTo.value = false;
    if (
        type == "integer" ||
        type == "bigInteger" ||
        type == "double" ||
        type == "decimal" ||
        type == "tinyInteger" ||
        type == "smallInteger"
    ) {
        selectType.value = "number";
    } else if (type == "text" || type == "tinyText" || type == "longText") {
        selectType.value = "text";
    } else if (type == "phone") {
        selectType.value = "phone";
    } else if (type == "date") {
        selectType.value = "date";
    } else if (type == "belongsTo") {
        selectType.value = "belongsTo";
        belongsTo.value = true;
    }
};

const ucFirst = (str) => {
    if (!str) return str;
    return (
        str[0].toUpperCase() +
        str.slice(1).split(" ").join("").trim().toLowerCase()
    );
};
</script>

<template>
    <q-page padding>
        <q-splitter
            v-model="splitterModel"
            style="height: 100%"
            :limits="[30, 50]"
        >
            <template v-slot:before>
                <q-separator />

                <e-card label="Controllers">
                    <q-chip
                        square
                        color="blue-2"
                        text-color="blue"
                        v-for="(item, i) in controllers"
                        :key="i"
                        >{{ item }}</q-chip
                    >
                </e-card>
                <q-separator />

                <e-card label="Models">
                    <q-chip
                        square
                        color="red-2"
                        text-color="red"
                        v-for="(item, i) in models"
                        :key="i"
                        >{{ item }}</q-chip
                    >
                </e-card>
                <q-separator />

                <e-card label="Resources"
                    ><q-chip
                        square
                        color="green-2"
                        text-color="green"
                        v-for="(item, i) in resources"
                        :key="i"
                        >{{ item }}</q-chip
                    ></e-card
                ><q-separator />

                <e-card label="Requests"
                    ><q-chip square v-for="(item, i) in requests" :key="i">{{
                        item
                    }}</q-chip></e-card
                >

                <e-card label="Tables"
                    ><q-chip square v-for="(item, i) in tables" :key="i">{{
                        item.Tables_in_jet_main_org
                    }}</q-chip></e-card
                >
                <q-separator />
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
                <q-card>
                    <q-tabs
                        v-model="form.tab"
                        dense
                        inline-label
                        align="justify"
                        class="text-primary shadow-2"
                        :breakpoint="0"
                    >
                        <q-tab
                            name="controller"
                            icon="mdi-gamepad-variant-outline"
                            label="Controllers"
                        />
                        <q-tab
                            name="model"
                            icon="mdi-database-refresh-outline"
                            label="Models"
                        />
                        <q-tab
                            name="resource"
                            icon="mdi-dresser-outline"
                            label="Resources"
                        />
                        <q-tab
                            name="request"
                            icon="mdi-tune-vertical"
                            label="Requests"
                        />
                    </q-tabs>

                    <q-tab-panels v-model="form.tab" animated>
                        <q-tab-panel name="controller">
                            <div class="q-ma-md">
                                <q-form
                                    @submit="onSubmit"
                                    @reset="onReset"
                                    class="q-gutter-md"
                                >
                                    <q-input
                                        clearable
                                        filled
                                        v-model="form.controller"
                                        label="Controller Name"
                                        hint="If You Like Set UserController Entre User Only"
                                        lazy-rules
                                        :rules="[
                                            (val) => !!val || $t('v.required'),
                                        ]"
                                        :error-message="form.errors.controller"
                                        :error="
                                            form.errors.controller
                                                ? true
                                                : false
                                        "
                                    />
                                    <div class="text-gary">
                                        Controller :
                                        {{ ucFirst(form.controller) }}Controller
                                    </div>
                                    <div class="">
                                        Model : {{ ucFirst(form.controller) }}
                                    </div>
                                    <div class="">
                                        Resource :
                                        {{ ucFirst(form.controller) }}Resource
                                    </div>
                                    <div class="">
                                        Require :
                                        {{ ucFirst(form.controller) }}Require
                                    </div>

                                    <q-separator />
                                    <div class="row">
                                        <div class="col q-px-sm">
                                            <q-input
                                                dense
                                                clearable
                                                filled
                                                v-model="item.name"
                                                label="Column Name"
                                            >
                                            </q-input>
                                        </div>
                                        <div class="col q-px-sm">
                                            <q-select
                                                filled
                                                v-model="item.type"
                                                :options="options"
                                                dense=""
                                                @update:model-value="setType"
                                            />
                                        </div>
                                        <div class="col q-px-sm">
                                            <q-input
                                                :type="selectType"
                                                dense
                                                clearable
                                                filled
                                                v-model="item.value"
                                                label="Default value"
                                            >
                                                <template #after>
                                                    <q-btn
                                                        flat
                                                        icon="add"
                                                        @click="addItem"
                                                    />
                                                </template>
                                            </q-input>
                                        </div>
                                    </div>

                                    <table-form
                                        :columns="columns"
                                        :rows="form.items"
                                        :belongsTo="belongsTo"
                                    >
                                        <template #select>
                                            <q-select
                                                filled
                                                v-model="item.belongsTo"
                                                :options="tables"
                                                dense
                                                emit-value
                                                option-value="Tables_in_jet_main_org"
                                                option-label="Tables_in_jet_main_org"
                                            />
                                        </template>
                                    </table-form>
                                    <q-separator />
                                    <q-btn
                                        class="full-width"
                                        :label="$t('g.save')"
                                        type="submit"
                                        color="primary"
                                        :loading="form.processing"
                                    />
                                </q-form>
                            </div>
                        </q-tab-panel>
                        <q-tab-panel name="model">
                            <one-form @submitted="submittedData">
                                <q-input
                                    clearable
                                    filled
                                    v-model="form.controller"
                                    label="Model Name"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    :error-message="form.errors.controller"
                                    :error="
                                        form.errors.controller ? true : false
                                    "
                                />

                                <div class="row q-mb-md">
                                    <div class="col q-pr-sm">
                                        <q-input
                                            dense
                                            clearable
                                            filled
                                            v-model="item.name"
                                            label="Column Name"
                                        >
                                        </q-input>
                                    </div>
                                    <div class="col q-px-sm">
                                        <q-select
                                            filled
                                            v-model="item.type"
                                            :options="options"
                                            dense=""
                                            @update:model-value="setType"
                                        />
                                    </div>
                                    <div class="col q-px-sm">
                                        <q-input
                                            :type="selectType"
                                            dense
                                            clearable
                                            filled
                                            v-model="item.value"
                                            label="Default value"
                                        >
                                            <template #after>
                                                <q-btn
                                                    flat
                                                    icon="add"
                                                    @click="addItem"
                                                />
                                            </template>
                                        </q-input>
                                    </div>
                                </div>

                                <table-form
                                    :columns="columns"
                                    :rows="form.items"
                                    :belongsTo="belongsTo"
                                >
                                    <template #select>
                                        <q-select
                                            filled
                                            v-model="item.belongsTo"
                                            :options="tables"
                                            dense
                                            emit-value
                                            option-value="Tables_in_jet_main_org"
                                            option-label="Tables_in_jet_main_org"
                                        />
                                    </template>
                                </table-form>

                                <q-btn
                                    class="full-width q-mt-md"
                                    label="create a new model only"
                                    type="submit"
                                    color="red"
                                    :loading="form.processing"
                                />
                            </one-form>
                        </q-tab-panel>
                        <q-tab-panel name="resource">
                            <one-form @submitted="submittedData">
                                <q-input
                                    clearable
                                    filled
                                    v-model="form.controller"
                                    label="Resource Name"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    :error-message="form.errors.controller"
                                    :error="
                                        form.errors.controller ? true : false
                                    "
                                />

                                <div class="">
                                    Resource :
                                    {{ ucFirst(form.controller) }}Resource
                                </div>

                                <q-btn
                                    class="full-width q-mt-md"
                                    label="create a new resource only"
                                    type="submit"
                                    color="red"
                                    :loading="form.processing"
                                />
                            </one-form>
                        </q-tab-panel>
                        <q-tab-panel name="request">
                            <one-form @submitted="submittedData">
                                <q-input
                                    clearable
                                    filled
                                    v-model="form.controller"
                                    label="Request Name"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    :error-message="form.errors.controller"
                                    :error="
                                        form.errors.controller ? true : false
                                    "
                                />
                                <div class="">
                                    Require :
                                    {{ ucFirst(form.controller) }}Require
                                </div>
                                <q-btn
                                    class="full-width q-mt-md"
                                    label="create a new request only"
                                    type="submit"
                                    color="red"
                                    :loading="form.processing"
                                />
                            </one-form>
                        </q-tab-panel>
                    </q-tab-panels>
                </q-card>
            </template>
        </q-splitter>
    </q-page>
</template>
