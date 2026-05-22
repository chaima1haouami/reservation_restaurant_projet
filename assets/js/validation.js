/* =========================
   VALIDATION GLOBALE FORMULAIRES
========================= */

document.addEventListener("DOMContentLoaded", function () {

    /* =========================
       LOGIN / REGISTER VALIDATION
    ========================= */

    const authForms = document.querySelectorAll("form.auth");

    authForms.forEach(form => {
        form.addEventListener("submit", function (e) {

            let email = form.querySelector("input[type='email']");
            let password = form.querySelector("input[type='password']");

            if (email && email.value.trim() === "") {
                e.preventDefault();
                alert("⚠️ Email obligatoire");
                return;
            }

            if (password && password.value.length < 6) {
                e.preventDefault();
                alert("⚠️ Mot de passe doit contenir au moins 6 caractères");
                return;
            }
        });
    });


    /* =========================
       RÉSERVATION VALIDATION
    ========================= */

    const reservationForm = document.querySelector("form.reservation");

    if (reservationForm) {
        reservationForm.addEventListener("submit", function (e) {

            let nom = reservationForm.querySelector("input[name='nom']").value;
            let date = reservationForm.querySelector("input[name='date']").value;
            let heure = reservationForm.querySelector("input[name='heure']").value;
            let personnes = reservationForm.querySelector("input[name='personnes']").value;

            if (nom.trim() === "") {
                e.preventDefault();
                alert("⚠️ Nom obligatoire");
                return;
            }

            if (date === "") {
                e.preventDefault();
                alert("⚠️ Date obligatoire");
                return;
            }

            if (heure === "") {
                e.preventDefault();
                alert("⚠️ Heure obligatoire");
                return;
            }

            if (personnes <= 0) {
                e.preventDefault();
                alert("⚠️ Nombre de personnes invalide");
                return;
            }
        });
    }

});