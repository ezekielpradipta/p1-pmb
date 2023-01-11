import { createApp } from "vue";

import "./app.css";
import "./assets/scss/global.scss";
import "flowbite";
import store from "./store";
import router from "./router";
import PerfectScrollbar from "vue3-perfect-scrollbar";
import "vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

import BaseButton from "./components/BaseButton.vue";
import BaseLink from "./components/BaseLink.vue";
import BaseInput from "./components/BaseInput.vue";
import BaseLabel from "./components/BaseLabel.vue";
import BaseCard from "./components/BaseCard.vue";
import Search from "./components/Search.vue";
import BaseTable from "./components/BaseTable.vue";
import FormMaster from "./components/FormMaster.vue";
import FormStep from "./components/FormStep.vue";

import AuthHeader from "./views/layouts/Custom/AuthHeader.vue";
import ChildTransition from "./views/layouts/Custom/ChildTransition.vue";
import ParentTransition from "./views/layouts/Custom/ParentTransition.vue";
import PageHeader from "./views/layouts/Custom/PageHeader.vue";
import ProfileDropdown from "./views/layouts/Custom/ProfileDropdown.vue";

import VueCountdown from "@chenfengyuan/vue-countdown";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import App from "./App.vue";

createApp(App)
    .use(router)
    .component("BaseButton", BaseButton)
    .component("BaseLink", BaseLink)
    .component("BaseInput", BaseInput)
    .component("BaseLabel", BaseLabel)
    .component("BaseCard", BaseCard)
    .component("Search", Search)
    .component("BaseTable", BaseTable)
    .component("FormMaster", FormMaster)
    .component("FormStep", FormStep)
    .component("AuthHeader", AuthHeader)
    .component("ChildTransition", ChildTransition)
    .component("ParentTransition", ParentTransition)
    .component("PageHeader", PageHeader)
    .component("ProfileDropdown", ProfileDropdown)
    .component(VueCountdown.name, VueCountdown)
    .component("Datepicker", Datepicker)
    .use(PerfectScrollbar)
    .use(VueSweetalert2)
    .use(store)

    .mount("#app");
