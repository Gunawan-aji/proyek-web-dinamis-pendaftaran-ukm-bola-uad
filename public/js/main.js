document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registrationForm");
    const formMessage = document.getElementById("form-message");

    if (form) {
        form.addEventListener("submit", async (event) => {
            event.preventDefault();

            // Reset pesan notifikasi
            formMessage.textContent = "";
            formMessage.className = "message-area";

            // Dapatkan data dari form
            const formData = new FormData(form);

            // Tampilkan loading/disable tombol
            const submitButton = form.querySelector(".btn-submit");
            submitButton.disabled = true;
            submitButton.textContent = "Memproses...";

            try {
                // Gunakan Fetch API untuk mengirim data ke register.php
                const response = await fetch("register.php", {
                    method: "POST",
                    body: formData,
                });

                // Pastikan response adalah JSON
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                // Tampilkan pesan berdasarkan hasil dari server (register.php)
                if (result.success) {
                    formMessage.classList.add("message-success");
                    formMessage.textContent = result.message;
                    form.reset(); // Reset form jika berhasil
                } else {
                    formMessage.classList.add("message-error");
                    formMessage.textContent =
                        result.message ||
                        "Pendaftaran gagal. Silakan coba lagi.";
                }
            } catch (error) {
                console.error("Error saat submit form:", error);
                formMessage.classList.add("message-error");
                formMessage.textContent =
                    "Terjadi kesalahan jaringan atau server. Detail: " +
                    error.message;
            } finally {
                // Aktifkan kembali tombol setelah proses selesai
                submitButton.disabled = false;
                submitButton.textContent = "Daftar Sekarang";
            }
        });
    }
});
