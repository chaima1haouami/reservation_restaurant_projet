// =========================
// MENU LUXE INTERACTIONS
// =========================

document.addEventListener("DOMContentLoaded", function () {

    // Animation d’apparition des cartes
    const cards = document.querySelectorAll(".menu-card");

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, {
        threshold: 0.1
    });

    cards.forEach(card => {
        card.style.opacity = "0";
        card.style.transform = "translateY(30px)";
        card.style.transition = "0.6s ease";
        observer.observe(card);
    });

    // Effet hover sonore (optionnel UX luxe)
    cards.forEach(card => {
        card.addEventListener("mouseenter", () => {
            card.style.boxShadow = "0 10px 30px rgba(201, 168, 76, 0.2)";
        });

        card.addEventListener("mouseleave", () => {
            card.style.boxShadow = "none";
        });
    });

    // Confirmation avant commande
    const orderButtons = document.querySelectorAll(".btn-order");

    orderButtons.forEach(btn => {
        btn.addEventListener("click", function (e) {
            const confirmOrder = confirm("🍽️ Voulez-vous commander ce plat ?");
            if (!confirmOrder) {
                e.preventDefault();
            }
        });
    });

});