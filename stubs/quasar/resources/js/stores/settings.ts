import ar from 'quasar/lang/ar';
import en from 'quasar/lang/en-US'
import { Quasar } from "quasar";
import { defineStore } from 'pinia';

export const useSettings = defineStore("settings-store", {
    state: () => ({
        splitterModel: 50,
        quasarLang: "",
        title : "",
        supTitle : "",
        icon : "widgets",
        supIcon : "edit",
        loading : false
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
