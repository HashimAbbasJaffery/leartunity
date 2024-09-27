import { defineStore } from "pinia";
import {ref} from "vue";

export const useLocaleStore = defineStore("localeStore", () => {
    const localeData = ref([]);

    const setLocaleData = data => {
        localeData.value = data;
    }

    return {localeData, setLocaleData}
})
