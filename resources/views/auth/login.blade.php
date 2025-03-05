<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Welcome Back!</h1>
        </div>
        <form id="loginForm">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                <p id="emailError" class="text-red-500 text-sm mt-2"></p>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                <p id="passwordError" class="text-red-500 text-sm mt-2"></p>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                Log in
            </button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loginForm = document.getElementById("loginForm");
            const emailInput = document.getElementById("email");
            const passwordInput = document.getElementById("password");
            const emailError = document.getElementById("emailError");
            const passwordError = document.getElementById("passwordError");

            // Cek apakah user masih dalam masa blokir (simpan di localStorage)
            let blockedUntil = localStorage.getItem("blockedUntil");
            if (blockedUntil && blockedUntil > Date.now() / 1000) {
                showBlockAlert(blockedUntil - Date.now() / 1000);
            }

            loginForm.addEventListener("submit", async function(event) {
                event.preventDefault();
                const email = emailInput.value;
                const password = passwordInput.value;

                // Hapus pesan error lama
                emailError.textContent = "";
                passwordError.textContent = "";

                try {
                    let response = await fetch("{{ route('login') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")
                        },
                        body: JSON.stringify({
                            email,
                            password
                        })
                    });

                    let result = await response.json();

                    if (result.status === "blocked") {
                        let remainingTime = result.remainingTime; // Waktu tersisa dalam detik
                        let unblockTime = Math.floor(Date.now() / 1000) + remainingTime;

                        // Simpan waktu blokir di localStorage
                        localStorage.setItem("blockedUntil", unblockTime);

                        showBlockAlert(remainingTime);
                    } else if (result.status === "error") {
                        passwordError.textContent = result.message;
                    } else {
                        // Jika login berhasil, hapus blokir di localStorage & redirect ke dashboard
                        localStorage.removeItem("blockedUntil");
                        window.location.href = "{{ route('dashboard') }}";
                    }
                } catch (error) {
                    Swal.fire({
                        icon: "error",
                        title: "Terjadi kesalahan!",
                        text: "Coba lagi nanti.",
                        confirmButtonText: "OK"
                    });
                }
            });

            function showBlockAlert(remainingTime) {
                Swal.fire({
                    title: "Terlalu Banyak Percobaan!",
                    html: `Silakan coba lagi dalam <b>${formatTime(remainingTime)}</b>`,
                    icon: "error",
                    backdrop: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        const interval = setInterval(() => {
                            remainingTime--;
                            if (remainingTime <= 0) {
                                clearInterval(interval);
                                Swal.close();
                                localStorage.removeItem(
                                    "blockedUntil"); // Hapus dari localStorage
                            } else {
                                Swal.getHtmlContainer().innerHTML =
                                    `Silakan coba lagi dalam <b>${formatTime(remainingTime)}</b>`;
                            }
                        }, 1000);
                    }
                });
            }

            function formatTime(seconds) {
                seconds = Math.floor(seconds); // Bulatkan angka ke bawah
                let minutes = Math.floor(seconds / 60);
                let remainingSeconds = seconds % 60;
                return `${minutes.toString().padStart(2, "0")}:${remainingSeconds.toString().padStart(2, "0")}`;
            }

        });
    </script>
</body>

</html>
