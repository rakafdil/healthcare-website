<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-4 text-center">Lupa Password</h2>

        <!-- Pesan Sukses -->
        <div id="successMessage" class="alert alert-success d-none"></div>

        <!-- Pesan Error -->
        <div id="errorMessage" class="alert alert-danger d-none"></div>

        <form id="forgotPasswordForm" method="POST" action="#">
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control"
                    placeholder="Masukkan email kamu" required autofocus>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    Kirim Link Reset Password
                </button>
            </div>
        </form>

        <div class="mt-3 text-center">
            <a href="login.html">← Kembali ke halaman login</a>
        </div>
    </div>

    <script>
        // Contoh handling form secara lokal (tanpa server)
        document.getElementById('forgotPasswordForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const email = document.getElementById('email').value;

            if (email === '') {
                document.getElementById('errorMessage').textContent = 'Email harus diisi.';
                document.getElementById('errorMessage').classList.remove('d-none');
                document.getElementById('successMessage').classList.add('d-none');
                return;
            }

            // Simulasi pengiriman sukses
            document.getElementById('successMessage').textContent = 'Link reset password telah dikirim ke email Anda.';
            document.getElementById('successMessage').classList.remove('d-none');
            document.getElementById('errorMessage').classList.add('d-none');

            // Reset form
            document.getElementById('forgotPasswordForm').reset();
        });
    </script>
</body>

</html>
