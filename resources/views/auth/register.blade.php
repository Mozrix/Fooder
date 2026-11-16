
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Fooder</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 20px;
            background: #F7F8FA;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            background: #FFFFFF;
            padding: 38px;
            border: 1px solid #E9E9E9;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        .brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-name {
            color: #FF6B0B;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .brand-description {
            color: #888888;
            font-size: 13px;
            margin-top: 7px;
        }

        .heading {
            margin-bottom: 25px;
        }

        .heading h2 {
            color: #222222;
            font-size: 24px;
            margin-bottom: 8px;
        }

        .heading p {
            color: #888888;
            font-size: 14px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 17px;
        }

        .form-group label {
            display: block;
            color: #333333;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            height: 45px;
            padding: 0 14px;
            border: 1px solid #DDDDDD;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            color: #333333;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #FF6B0B;
            box-shadow: 0 0 0 3px rgba(255, 107, 11, 0.10);
        }

        .form-group input::placeholder {
            color: #AAAAAA;
        }

        .btn-submit {
            width: 100%;
            height: 47px;
            margin-top: 5px;
            border: none;
            border-radius: 8px;
            background: #FF6B0B;
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-submit:hover {
            background: #F05A00;
            box-shadow: 0 4px 12px rgba(255, 107, 11, 0.20);
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            color: #777777;
            font-size: 14px;
        }

        .footer a {
            color: #FF6B0B;
            text-decoration: none;
            font-weight: 700;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .alert {
            background: #FFF0EF;
            color: #C0392B;
            border: 1px solid #F5D0CC;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .error {
            color: #DC3545;
            font-size: 12px;
            margin-top: 6px;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 30px 23px;
            }

            .brand-name {
                font-size: 29px;
            }
        }
    </style>
</head>

<body>

    <div class="auth-card">

        <div class="brand">
            <div class="brand-name">Fooder.</div>
            <p class="brand-description">Solusi pemesanan makanan lebih mudah</p>
        </div>

        <div class="heading">
            <h2>Buat Akun Baru</h2>
            <p>Daftarkan diri Anda untuk mulai menggunakan Fooder.</p>
        </div>

        @if ($errors->any())
            <div class="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder="Masukkan nama lengkap"
                    autocomplete="name"
                    required
                >
                @error('nama')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email Anda"
                    autocomplete="email"
                    required
                >
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    autocomplete="new-password"
                    required
                >
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    Konfirmasi Password
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Masukkan ulang password"
                    autocomplete="new-password"
                    required
                >
            </div>

            <button type="submit" class="btn-submit">
                Daftar Sekarang
            </button>
        </form>

        <div class="footer">
            Sudah memiliki akun?
            <a href="{{ route('login') }}">Masuk di sini</a>
        </div>

    </div>

</body>
</html>
