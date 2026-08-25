import "./bootstrap";
import "./dashboard-charts";
import "flatpickr/dist/flatpickr.min.css";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/dark.css";

import Alpine from "alpinejs";

window.Alpine = Alpine;
window.addEventListener("load", function () {
    flatpickr("#flatpickr-date", {
        monthSelectorType: "dropdown",
        dateFormat: "Y-m-d",
        minDate: "today",
    });
});

Alpine.start();
