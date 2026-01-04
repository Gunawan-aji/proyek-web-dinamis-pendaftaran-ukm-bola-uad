document.addEventListener("DOMContentLoaded", function () {
    // --- 1. FITUR SCROLL NAVBAR ---
    const body = document.body;
    const menuToggle = document.querySelector("#mobile-menu");
    const navMenu = document.querySelector(".nav-menu");
    const navLinks = document.querySelectorAll(".nav-menu a");

    function checkScroll() {
        if (window.scrollY > 50) {
            body.classList.add("scrolled");
        } else {
            body.classList.remove("scrolled");
        }
    }

    // --- 2. FITUR HAMBURGER MENU (MOBILE) ---
    if (menuToggle && navMenu) {
        menuToggle.addEventListener("click", function () {
            navMenu.classList.toggle("active");

            // Animasi ikon: ganti bar jadi X (fa-times)
            const icon = menuToggle.querySelector("i");
            if (navMenu.classList.contains("active")) {
                icon.classList.replace("fa-bars", "fa-times");
            } else {
                icon.classList.replace("fa-times", "fa-bars");
            }
        });

        // Tutup menu otomatis saat link navigasi diklik
        navLinks.forEach((link) => {
            link.addEventListener("click", () => {
                navMenu.classList.remove("active");
                const icon = menuToggle.querySelector("i");
                icon.classList.replace("fa-times", "fa-bars");
            });
        });
    }

    // --- 3. EVENT LISTENERS ---
    window.addEventListener("scroll", checkScroll);

    // Jalankan sekali saat load
    checkScroll();
});
