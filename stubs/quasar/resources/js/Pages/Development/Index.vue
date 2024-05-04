<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ECard from "@/Components/Widgets/ECard.vue";
import { ref } from "vue";
import { useForms } from "../../Composables/rules";
import { useForm } from "@inertiajs/vue3";
import { Notify } from "quasar";

defineProps(["controllers", "models", "resources", "requests", "tables"]);
defineOptions({
    layout: AppLayout,
});
const splitterModel = ref(30);
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
    model: true,
    resource: false,
    request: false,
});

const onSubmit = () => {
    form.post(route("development.store"), {
        preserveState: true,
        onFinish: () => form.reset(),
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
                        >{{ item}}</q-chip
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
                            :rules="[(val) => !!val || $t('v.required')]"
                            :error-message="form.errors.controller"
                            :error="form.errors.controller ? true : false"
                        />
                        <div class="text-gary">
                            1- Controller , 2- Model , 3- Resource , 4- Require
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

                        <div class="row" v-if="belongsTo">
                            <div class="col q-px-sm">
                                <q-select
                                    filled
                                    v-model="item.belongsTo"
                                    :options="tables"
                                    dense
                                    emit-value
                                    option-value="Tables_in_jet_main_org"
                                    option-label="Tables_in_jet_main_org"
                                />
                            </div>
                            <div class="col q-px-sm">
                                <q-input
                                    dense
                                    clearable
                                    filled
                                    disable
                                    label="id"
                                >
                                </q-input>
                            </div>
                        </div>
                        <q-separator />

                        <q-table
                            :rows="form.items"
                            :columns="columns"
                            title="Default Field is : | id | user_id | account_id "
                            :rows-per-page-options="[]"
                            row-key="name"
                        >
                            <template v-slot:body="props">
                                <q-tr :props="props">
                                    <q-td key="name" :props="props">
                                        {{ props.row.name }}
                                    </q-td>
                                    <q-td key="filed" :props="props">
                                        <q-input
                                            outlined=""
                                            v-model="props.row.filed"
                                            dense
                                            autofocus
                                        />
                                    </q-td>
                                    <q-td key="type" :props="props">
                                        {{ props.row.type }}
                                    </q-td>

                                    <q-td key="value" :props="props">
                                        {{ props.row.value || "-" }}
                                    </q-td>

                                    <q-td key="require" :props="props">
                                        <q-checkbox
                                            v-model="props.row.require"
                                        />
                                    </q-td>
                                </q-tr>
                            </template>
                        </q-table>

                        <q-separator />
                        <q-btn
                            class="full-width"
                            :label="$t('g.save')"
                            type="submit"
                            color="primary"
                            :loading="form.loading"
                        />
                    </q-form>
                </div>
            </template>
        </q-splitter>
    </q-page>
</template>
