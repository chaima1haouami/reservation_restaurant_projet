/* =========================
   VALIDATION RÉSERVATION
========================= */

document.addEventListener("DOMContentLoaded", function () {

    const form = document.querySelector("form.reservation");

    if (!form) return;

    form.addEventListener("submit", function (e) {

        const nom = document.querySelector("input[name='nom']").value.trim();
        const date = document.querySelector("input[name='date']").value;
        const heure = document.querySelector("input[name='heure']").value;
        const personnes = document.querySelector("input[name='personnes']").value;

        // champ vide
        if (nom === "" || date === "" || heure === "" || personnes === "") {
            e.preventDefault();
            alert("⚠️ Tous les champs sont obligatoires !");
            return;
        }

        // nombre invalide
        if (parseInt(personnes) <= 0) {
            e.preventDefault();
            alert("⚠️ Nombre de personnes invalide !");
            return;
        }
    });

});