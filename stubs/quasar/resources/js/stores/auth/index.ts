import ar from 'quasar/lang/ar';
import en from 'quasar/lang/en-US'
import { defineStore } from "pinia";
import axios from "axios";
import type { LoginType, User } from "@/types";

import { Quasar } from "quasar";
import { useI18n } from 'vue-i18n'


export const useAuth = defineStore("auth-store", {
    state: () => ({
        splitterModel: 50,
        quasarLang: ""
    }),

    actions: {
        chingLang() {
            if (this.quasarLang === "en-US") {
                console.log(Quasar.lang.isoName)
                this.quasarLang = "ar"
                Quasar.lang.set(ar)
            } else if(this.quasarLang === "ar") {
                this.quasarLang = "en-US"
                Quasar.lang.set(en)
            }else{
                this.quasarLang = "en-US"
                Quasar.lang.set(en)
            }
        }

    },
});
