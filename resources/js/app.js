import "./bootstrap";
import "flatpickr/dist/flatpickr.min.css";
import flatpickr from "flatpickr";

import Alpine from "alpinejs";

window.Alpine = Alpine;
window.addEventListener("load", function () {
    flatpickr("#flatpickr-date", {
        monthSelectorType: "static",
        dateFormat: "Y-m-d",
    });
});

Alpine.start();
