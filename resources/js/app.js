import "./bootstrap";
import "flyonui/flyonui";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("menu-toggle");
    const menu = document.getElementById("mobile-menu");

    toggle.addEventListener("click", function () {
        menu.classList.toggle("hidden");
    });
});
