import { router } from "@inertiajs/vue3";
import axios from "axios";
import { defineStore } from "pinia";
import { Notify } from "quasar";

export const useTables = defineStore("auth-tables", {
    state: () => ({
        row: {},
        newRow: false,
        editRow: false,
        showRow: false,
        confirm: false,
        outPage: false,
        splitterModel: 50,
        filters: { s: "", sortBy: "id", trashed: "", type: 1 },
        pagination: {
            sortType: "desc",
            descending: false,
            page: 1,
            rowsPerPage: 15,
            rowsNumber: 0,
        },
        query: {
            page: 1,
        },
        loading: false,
        selected: [],
        visibleColumns: [],
        router: <String>(<unknown>""),
        trashedData: [
            { name: "table.d", id: "" },
            { name: "table.only", id: "only" },
            { name: "table.with", id: "with" },
        ],
    }),

    actions: {
        setFilter(filter: string) {
            this.filters.s = filter;
        },

        setRouter(text: String) {
            this.router = text;
        },
        getSelected() {
            console.log(this.selected);
        },

        editItem(item: any) {
            this.row = item;
            this.editRow = true;
        },

        showItem(item: any) {
            this.row = item;
            this.showRow = true;
        },
    },
});
