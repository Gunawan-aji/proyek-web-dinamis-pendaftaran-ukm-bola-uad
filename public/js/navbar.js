// assets/js/main.js

document.addEventListener("DOMContentLoaded", function() {
    const header = document.querySelector(".hero"); // Atau .navbar, tergantung elemen mana yang ingin diberi background
    
    // Fungsi untuk mengubah kelas berdasarkan posisi scroll
    function checkScroll() {
        if (window.scrollY > 50) {
            // Jika discroll lebih dari 50px, tambahkan kelas 'scrolled'
            header.classList.add("scrolled");
        } else {
            // Jika berada di atas, hapus kelas 'scrolled'
            header.classList.remove("scrolled");
        }
    }

    // Panggil fungsi saat event scroll terjadi
    window.addEventListener("scroll", checkScroll);

    // Panggil sekali saat dimuat untuk memastikan status jika halaman dimuat di tengah
    checkScroll();
});