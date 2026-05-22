/* =========================
   MENU MOBILE (NAVBAR)
========================= */

const burger = document.querySelector(".burger");
const nav = document.querySelector(".nav-links");

if (burger) {
    burger.addEventListener("click", () => {
        nav.classList.toggle("open");
    });
}

/* =========================
   SMOOTH SCROLL
========================= */

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));
        if (target) {
            target.scrollIntoView({
                behavior: "smooth"
            });
        }
    });
});