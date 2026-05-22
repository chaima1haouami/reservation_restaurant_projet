<?php
include 'config/db.php';
include 'includes/header.php';
?>

<!-- HERO LUXE -->
<section class="hero">

    <!-- SLIDER BACKGROUND -->
    <div class="hero-slider">
        <div class="slide active" style="background-image:url('https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba');"></div>
        <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1559339352-11d035aa65de');"></div>
        <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1504674900247-0877df9cc836');"></div>
    </div>

    <!-- OVERLAY -->
    <div class="overlay"></div>

    <!-- CONTENT -->
    <div class="hero-content">

        <div class="hero-badge">Restaurant Premium</div>

        <h1>Gastronomie d’Exception</h1>

        <p>Une expérience culinaire élégante, moderne et raffinée</p>

        <a href="menu.php" class="btn-lux">Découvrir le menu</a>

    </div>

</section>

<script>
let slides = document.querySelectorAll(".slide");
let i = 0;

setInterval(() => {
    slides[i].classList.remove("active");
    i = (i + 1) % slides.length;
    slides[i].classList.add("active");
}, 4500);
</script>

<?php include 'includes/footer.php'; ?>