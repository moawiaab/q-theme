<template>
    <q-page padding>
        <q-table
            class="my-sticky-column-table"
            flat
            :style="`height : ${$q.screen.height - 90}px`"
            :title="title"
            ref="tableRef"
            :rows="rows.data"
            :columns="columns"
            binary-state-sort
            :selected-rows-label="table.getSelected()"
            v-model:selected="table.selected"
            :visible-columns="table.visibleColumns"
            :loading="loading"
            :pagination="pagination"
        >
            <template #bottom>
                <pagination-page :links="rows.meta" />
            </template>

            <template #loading>
                <loader />
            </template>
            <template v-slot:top-right>
                <q-select
                    class="q-mx-sm"
                    v-model="table.visibleColumns"
                    multiple
                    dense
                    outlined
                    options-dense
                    :display-value="$q.lang.table.columns"
                    emit-value
                    map-options
                    :options="columns"
                    option-value="name"
                    :option-label="(opt) => $t(opt.label)"
                    options-cover
                    style="min-width: 100px"
                />

                <q-select
                    class="q-mx-sm"
                    v-model="page"
                    dense
                    outlined
                    options-dense
                    map-options
                    :options="[5, 10, 15, 20, 25, 50, 100]"
                    style="min-width: 100px"
                />

                <q-btn
                    glossy
                    color="primary"
                    icon="archive"
                    dense
                    flat
                    rounded
                    no-caps
                    @click="exportTable"
                />
            </template>

            <template v-slot:top-left>
                <q-input
                    class="q-mx-sm"
                    dense
                    debounce="300"
                    v-model="filter"
                    :placeholder="$t('g.search')"
                    clearable
                    outlined
                >
                    <template #prepend>
                        <q-icon name="search" />
                    </template>
                    <template v-slot:after>
                        <slot name="filter" />
                    </template>
                </q-input>

                <q-select
                    class="q-mx-sm"
                    v-model="filters"
                    dense
                    outlined
                    options-dense
                    emit-value
                    map-options
                    :options="table.trashedData"
                    option-value="id"
                    :option-label="(opt) => $t(opt.name)"
                    options-cover
                    style="min-width: 100px"
                />
            </template>

            <!-- start expand -->

            <template #header="props" v-if="expand">
                <q-tr :props="props">
                    <q-th auto-width />
                    <q-th
                        v-for="col in props.cols"
                        :key="col.name"
                        :props="props"
                    >
                        {{ $t(col.label) }}
                    </q-th>
                </q-tr>
            </template>
            <template #header="props" v-else>
                <q-tr :props="props">
                    <q-th
                        v-for="col in props.cols"
                        :key="col.name"
                        :props="props"
                    >
                        {{ $t(col.label) }}
                    </q-th>
                </q-tr>
            </template>

            <template #body="props" v-if="expand">
                <q-tr :props="props">
                    <q-td auto-width>
                        <q-btn
                            glossy
                            size="sm"
                            color="accent"
                            round
                            dense
                            @click="props.expand = !props.expand"
                            :icon="props.expand ? 'remove' : 'add'"
                        />
                    </q-td>

                    <template v-for="col in props.cols">
                        <q-td
                            v-if="col.name != 'options'"
                            :key="col.name"
                            :props="props"
                        >
                            {{ col.value }}
                        </q-td>
                    </template>

                    <q-td
                        v-if="props.row.deleted_at"
                        class="deletedItem text-right"
                    >
                        <q-btn
                            glossy
                            icon="undo"
                            dense
                            flat
                            rounded
                            color="green"
                            @click="restoreItem(props.row.id)"
                            v-if="
                                deletable &&
                                $page.props.can.includes(`${role}_delete`)
                            "
                        />
                        <q-btn
                            glossy
                            icon="delete"
                            dense
                            flat
                            rounded
                            color="red"
                            @click="deleteItem(props.row)"
                            v-if="
                                deletable &&
                                $page.props.can.includes(`${role}_delete`)
                            "
                        />
                    </q-td>
                    <q-td :items="props.row" class="text-right" v-else>
                        <!-- {{ props.row.name }} -->
                        <slot name="options" :props="props.row" />
                        <q-btn
                            glossy
                            :icon="`${
                                props.row.toggle
                                    ? 'mdi-toggle-switch-outline'
                                    : 'mdi-toggle-switch-off-outline'
                            }`"
                            dense
                            flat
                            rounded
                            :color="`${
                                props.row.toggle ? 'accent' : 'negative'
                            }`"
                            @click="toggleItem(props.row.id)"
                            v-if="
                                toggle &&
                                $page.props.can.includes(`${role}_edit`)
                            "
                        />
                        <table-icon
                            :url="url + '.show'"
                            :pram="props.row.id"
                            icon="visibility"
                            color="green"
                            v-if="
                                viewable &&
                                $page.props.can.includes(`${role}_access`)
                            "
                        />
                        <table-icon
                            :url="url + '.edit'"
                            :pram="props.row.id"
                            v-if="
                                editable &&
                                $page.props.can.includes(`${role}_edit`)
                            "
                        />
                        <q-btn
                            glossy
                            icon="delete"
                            dense
                            flat
                            rounded
                            color="red"
                            @click="deleteItem(props.row)"
                            v-if="
                                deletable &&
                                $page.props.can.includes(`${role}_delete`)
                            "
                        />
                    </q-td>
                </q-tr>
                <q-tr v-show="props.expand" :props="props">
                    <q-td colspan="100%">
                        <div class="">
                            <slot name="table-body" :props="props" />
                        </div>
                    </q-td>
                </q-tr>
            </template>

            <!-- end expand -->

            <template #body-cell-options="props">
                <q-td
                    v-if="props.row.deleted_at"
                    class="deletedItem text-right"
                >
                    <table-icon
                        :url="url + '.show'"
                        :pram="props.row.id"
                        icon="visibility"
                        color="green"
                        v-if="viewable"
                    />
                    <q-btn
                        glossy
                        icon="undo"
                        dense
                        flat
                        rounded
                        color="green"
                        @click="restoreItem(props.row.id)"
                        v-if="
                            deletable &&
                            $page.props.can.includes(`${role}_delete`)
                        "
                    />
                    <q-btn
                        glossy
                        icon="delete"
                        dense
                        flat
                        rounded
                        color="red"
                        @click="deleteItem(props.row)"
                        v-if="
                            deletable &&
                            $page.props.can.includes(`${role}_delete`)
                        "
                    />
                </q-td>
                <q-td :items="props.row" class="text-right" v-else>
                    <!-- {{ props.row.name }} -->
                    <slot name="options" :props="props.row" />

                    <q-btn
                        glossy
                        :icon="`${
                            props.row.toggle
                                ? 'mdi-toggle-switch-outline'
                                : 'mdi-toggle-switch-off-outline'
                        }`"
                        dense
                        flat
                        rounded
                        :color="`${props.row.toggle ? 'accent' : 'negative'}`"
                        @click="toggleItem(props.row.id)"
                        v-if="
                            toggle && $page.props.can.includes(`${role}_edit`)
                        "
                    />

                    <table-icon
                        :url="url + '.show'"
                        :pram="props.row.id"
                        icon="visibility"
                        color="green"
                        v-if="
                            viewable &&
                            $page.props.can.includes(`${role}_access`)
                        "
                    />
                    <table-icon
                        :url="url + '.edit'"
                        :pram="props.row.id"
                        v-if="
                            editable && $page.props.can.includes(`${role}_edit`)
                        "
                    />

                    <q-btn
                        glossy
                        icon="delete"
                        dense
                        flat
                        rounded
                        color="red"
                        @click="deleteItem(props.row)"
                        v-if="
                            deletable &&
                            $page.props.can.includes(`${role}_delete`)
                        "
                    />
                </q-td>
            </template>

            <template v-for="(_, slot) of $slots" #[slot]="props">
                <slot :name="slot" :items="props" />
            </template>
        </q-table>

        <q-dialog v-model="table.confirm" persistent>
            <q-card>
                <q-card-section class="row column">
                    <div class="col">
                        <q-avatar
                            icon="folder_delete"
                            color="primary"
                            text-color="white"
                        />
                        <span v-if="table.row.deleted_at" class="q-ml-sm">
                            {{ $t("d.delete2") }}
                        </span>
                        <span v-else class="q-ml-sm">
                            {{ $t("d.delete1") }}</span
                        >
                        <q-separator />
                    </div>
                    <q-separator />
                    <div class="col">
                        <q-chip square>
                            {{ $t("g.id") }} : {{ table.row.id || 0 }}</q-chip
                        >
                        <q-chip square>
                            {{ $t("g.name") }} :
                            {{ table.row.name || table.row.title }}</q-chip
                        >
                    </div>
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn
                        glossy
                        flat
                        :label="$t('d.c')"
                        color="red"
                        v-close-popup
                    />
                    <q-btn
                        glossy
                        flat
                        :label="$t('d.d')"
                        color="primary"
                        @click="deleteItemFromDB(table.row.id)"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>

        <q-page-sticky position="bottom-right" :offset="[20, 20]">
            <Link
                v-if="props.newRow"
                :href="route(url + '.create')"
                class="q-btn q-mx-sm no-outline q-btn--rounded bg-primary text-white q-hoverable glossy"
            >
                <q-icon name="mdi-plus" />
            </Link>
            <!-- <fab :data="fabBtn" /> -->
        </q-page-sticky>
    </q-page>
</template>

<script setup>
import Fab from "@/Components/buttons/fab.vue";
import TableIcon from "@/Components/Widgets/TableIcon.vue";
import PaginationPage from "@/Components/pagination.vue";
import { useTables } from "@/stores/tables/index";
import { watch, onMounted, ref } from "vue";
import exportFile from "quasar/src/utils/export-file/export-file";
import useQuasar from "quasar/src/composables/use-quasar/use-quasar";
import { useAuth } from "@/stores/auth/index";
import { router, Link } from "@inertiajs/vue3";

const table = useTables();
const auth = useAuth();
table.$reset();

const props = defineProps({
    columns: { type: Array },
    rows: { type: Array },
    title: { type: String, default: "" },
    role: { type: String, default: "" },
    url: { type: String },
    expand: { type: Boolean, default: false },
    deletable: { type: Boolean, default: true },
    editable: { type: Boolean, default: true },
    viewable: { type: Boolean, default: true },
    newRow: { type: Boolean, default: true },
    toggle: { type: Boolean, default: false },
    creatable: { type: Boolean, default: false },
});

const tableRef = ref();
const filter = ref("");
const page = ref();
const filters = ref("");
const loading = ref(false);
const pagination = ref({
    page: props.rows.meta.current_page,
    rowsPerPage: props.rows.meta.per_page,
    rowsNumber: props.rows.meta.total,
    lastPage: props.rows.meta.last_page,
});

watch(filters, (e) => {
    table.filters.trashed = e;
    router.visit(props.url, {
        // only: ["users"],
        data: table.filters,
        preserveState: true,
        replace: true,
        onStart() {
            loading.value = true;
        },
        onFinish() {
            loading.value = false;
        },
    });
    // table.getData();
});

watch(page, (e) => {
    pagination.value.rowsPerPage = e;
    router.get(`${props.url}`, pagination.value, {
        replace: true,
        preserveState: true,
        onStart() {
            loading.value = true;
        },
        onFinish() {
            loading.value = false;
        },
    });
    // table.getData();
});

const deleteItemFromDB = (id) => {
    router.delete(`${props.url}/${id}`, {
        preserveState: true,
        replace: true,
        onStart() {
            loading.value = true;
            table.confirm = false;
        },
        onFinish() {
            loading.value = false;
        },
    });
};

const restoreItem = (id) => {
    router.put(
        `${props.url}/${id}/restore`,
        {},
        {
            preserveState: true,
            replace: true,
            onStart() {
                loading.value = true;
            },
            onFinish() {
                loading.value = false;
            },
        }
    );
};

const toggleItem = (id) => {
    router.put(
        `${props.url}/${id}/toggle`,
        {},
        {
            preserveState: true,
            replace: true,
            onStart() {
                loading.value = true;
            },
            onFinish() {
                loading.value = false;
            },
            onError(error) {
                console.error(error.message);
            },
        }
    );
};

watch(
    filter,
    (e) => {
        table.setFilter(e);
        router.get(
            props.url,
            { ...table.filters, ...pagination },
            {
                replace: true,
                preserveState: true,
                onStart() {
                    loading.value = true;
                },
                onFinish() {
                    loading.value = false;
                },
            }
        );
    },
    true
);

onMounted(() => {
    table.visibleColumns = props.columns.map((e) => e.name);
    tableRef.value.requestServerInteraction();
    page.value = props.rows.meta.per_page;
});

const deleteItem = (item) => {
    table.confirm = true;
    table.row = item;
};

function wrapCsvValue(val, formatFn, row) {
    let formatted = formatFn !== void 0 ? formatFn(val, row) : val;
    formatted =
        formatted === void 0 || formatted === null ? "" : String(formatted);
    formatted = formatted.split('"').join('""');
    return `"${formatted}"`;
}

const exportTable = () => {
    // naive encoding to csv format
    const content = [props.columns.map((col) => wrapCsvValue(col.label))]
        .concat(
            props.rows.map((row) =>
                props.columns
                    .map((col) =>
                        wrapCsvValue(
                            typeof col.field === "function"
                                ? col.field(row)
                                : row[
                                      col.field === void 0
                                          ? col.name
                                          : col.field
                                  ],
                            col.format,
                            row
                        )
                    )
                    .join(",")
            )
        )
        .join("\r\n");

    const status = exportFile("table-export.csv", content, "text/csv");

    if (status !== true) {
        $q.notify({
            message: "Browser denied file download...",
            color: "negative",
            icon: "warning",
        });
    }
};

const fabBtn = [
    {
        color: "green",
        icon: "sync",
        label: "f.refresh",
        onClick: () => {
            table.setRouter(props.url);
            table.getData();
        },
        disable: table.loading,
    },
    {
        color: "secondary",
        icon: "replay",
        label: "f.reset",
        onClick: () => {
            table.$reset();
            table.setRouter(props.url);
            table.visibleColumns = props.columns.map((e) => e.name);
            tableRef.value.requestServerInteraction();
            table.getData();
        },
        disable: table.loading,
    },
    {
        color: "accent",
        icon: "file_download",
        label: "f.exile",
        onClick: () => exportTable(),
    },
    { color: "primary", icon: "home", label: "f.d", to: "/" },
];
</script>

<style>
tr:has(td.deletedItem) {
    background: #ffb3bc80 !important;
}
</style>
<style lang="sass">
.my-sticky-column-table
  max-width: 100%

  td:last-child,
  td:first-child
    background-color: #ffffff

  tr th ,thead tr:last-child th:last-child,thead tr:first-child th:first-child
    position: sticky
    z-index: 1
  /* this will be the loading indicator */
  thead tr:last-child th
    /* height of all previous header rows */
    top: 48px
  thead tr:first-child th
    top: 0

  thead tr:last-child th
    /* height of all previous header rows */
    top: 48px
    /* highest z-index */
    z-index: 3
  thead tr:first-child th
    top: 0
    z-index: 1
  tr:last-child th:last-child
    /* highest z-index */
    z-index: 3

  td:last-child
    z-index: 1

  td:last-child, th:last-child
    position: sticky
    right: 0
  thead tr:first-child th /* bg color is important for th; just specify one */
    background-color: #fff


  th:last-child,
  td:last-child
    position: sticky
    right: 0
    z-index: 0
tr:has(td.deletedItem)
  td
    background: #ffb3bc80 !important
</style>
