import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("menu-toggle");
    const menu = document.getElementById("mobile-menu");

    toggle.addEventListener("click", function () {
        menu.classList.toggle("hidden");
    });
});
