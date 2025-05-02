<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .register-box h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            margin-bottom: 5px;
        }
        .form-group input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }
        .form-actions button {
            background: #2563eb;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .form-actions a {
            font-size: 14px;
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Register</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Ganti input name jadi id_pegawai -->
            <div class="form-group">
                <label for="id_pegawai">ID Pegawai</label>
                <input id="id_pegawai" type="text" name="id_pegawai" value="{{ old('id_pegawai') }}" required autofocus>
                @error('id_pegawai')
                    <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>

            <!-- Hapus email dan ganti jadi id_pegawai -->
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
                @error('password_confirmation')
                    <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('login') }}">Already registered?</a>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
</body>
</html>
