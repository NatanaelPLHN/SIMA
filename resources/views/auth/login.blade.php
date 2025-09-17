<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMA DISKOMINFO Kota Samarinda</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="container">

        <div class="left-side">
            <img src="{{ asset('assets/img/login.svg') }}" alt="Login Illustration" class="illustration">
        </div>

        <div class="right-side">
            <div class="logo-container">
                <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo" class="logo">
                <div>
                    <div class="app-name">SIMA</div>
                    <div class="app-subtitle">Sistem Manajemen Aset DISKOMINFO</div>
                </div>
            </div>
            
            <div class="login-form">
                <h2 class="form-title">Sign in to SIMA</h2>
                <p class="form-description">Gunakan Email dan Password Anda</p>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email') }}"
                               placeholder="Email"
                               required autofocus
                               class="form-input @error('email') is-invalid @enderror">
                        @error('email')
                            <div style="color: red; font-size: 12px;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div style="position: relative;">
                            <input type="password" name="password" id="password"
                                   placeholder="Password"
                                   required
                                   class="form-input @error('password') is-invalid @enderror">
                            <span class="password-toggle" onclick="togglePassword()">show</span>
                        </div>
                        @error('password')
                            <div style="color: red; font-size: 12px;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Button -->
                    <button type="submit" class="login-button">LOGIN</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pass = document.getElementById("password");
            const toggle = document.querySelector(".password-toggle");
            if (pass.type === "password") {
                pass.type = "text";
                toggle.textContent = "hide";
            } else {
                pass.type = "password";
                toggle.textContent = "show";
            }
        }
    </script>
</body>
</html>
