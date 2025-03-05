<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Verifikasi OTP</h1>
            <p class="text-gray-600 text-sm">Masukkan kode OTP yang telah dikirim ke email Anda.</p>
        </div>
        <form action="{{ route('password.verify.otp') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ request()->email }}">

            <div class="mb-4">
                <label for="otp" class="block text-gray-700">Kode OTP</label>
                <input type="text" name="otp" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 text-center">
                @error('otp')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                Verifikasi
            </button>
        </form>
    </div>
</body>

</html>
