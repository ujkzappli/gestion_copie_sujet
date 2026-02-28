<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion - UJKZ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Formes décoratives subtiles */
        body::before {
            content: '';
            position: fixed;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #667eea15, #764ba215);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            z-index: 0;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #667eea10, #764ba210);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            z-index: 0;
            pointer-events: none;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            margin: auto;
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }

        /* Partie gauche - Illustration */
        .left-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 0 30px 30px 0;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
        }

        .logo-container {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .logo-container img {
            max-width: 180px;
            height: auto;
            display: block;
        }

        .illustration-text {
            color: white;
            text-align: center;
            max-width: 450px;
        }

        .illustration-text h2 {
            font-size: 1.6rem;
            margin-bottom: 12px;
            font-weight: 700;
            line-height: 1.3;
        }

        .illustration-text p {
            font-size: 1rem;
            opacity: 0.9;
            line-height: 1.5;
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 25px;
            width: 100%;
            max-width: 380px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.1);
            padding: 10px 16px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            font-size: 0.9rem;
        }

        .feature-item i {
            font-size: 1.3rem;
        }

        /* Partie droite - Formulaire */
        .right-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 30px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .login-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            font-size: 0.85rem;
        }

        .form-label i {
            color: #667eea;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 1rem;
            padding: 5px;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: #6c757d;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .forgot-password {
            font-size: 0.85rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            padding: 11px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-danger {
            background: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            color: #6c757d;
            font-size: 0.8rem;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .container {
                flex-direction: column;
                min-height: auto;
            }

            .left-side {
                border-radius: 0;
                padding: 30px 25px;
                min-height: auto;
            }

            .logo-container {
                padding: 20px;
                margin-bottom: 20px;
            }

            .logo-container img {
                max-width: 140px;
            }

            .illustration-text h2 {
                font-size: 1.3rem;
            }

            .illustration-text p {
                font-size: 0.9rem;
            }

            .features {
                display: none;
            }

            .right-side {
                padding: 35px 25px;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }

            .login-header p {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            body {
                min-height: 100vh;
            }

            .container {
                padding: 0;
            }

            .left-side {
                padding: 25px 20px;
            }

            .logo-container img {
                max-width: 120px;
            }

            .illustration-text h2 {
                font-size: 1.1rem;
            }

            .right-side {
                padding: 30px 20px;
            }

            .login-card {
                max-width: 100%;
            }

            .login-header {
                margin-bottom: 25px;
            }

            .form-group {
                margin-bottom: 18px;
            }

            .form-input {
                padding: 11px 12px 11px 40px;
                font-size: 0.9rem;
            }

            .btn-login {
                padding: 12px;
                font-size: 0.9rem;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .footer-text {
                margin-top: 20px;
                font-size: 0.75rem;
            }
        }

        @media (max-height: 700px) {
            .login-header {
                margin-bottom: 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .logo-container {
                margin-bottom: 15px;
            }

            .features {
                margin-top: 15px;
                gap: 8px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    
    <!-- Partie gauche - Illustration -->
    <div class="left-side">
        <div class="logo-container">
            <img src="{{ asset('assets/images/image.png') }}" alt="UJKZ Logo">
        </div>
        
        <div class="illustration-text">
            <h2>Système de Gestion des Copies</h2>
            <p>Université Joseph KI-ZERBO</p>
        </div>

        <div class="features">
            <div class="feature-item">
                <i class="bi bi-shield-check"></i>
                <span>Connexion sécurisée</span>
            </div>
            <div class="feature-item">
                <i class="bi bi-speedometer2"></i>
                <span>Interface rapide</span>
            </div>
            <div class="feature-item">
                <i class="bi bi-graph-up"></i>
                <span>Suivi en temps réel</span>
            </div>
        </div>
    </div>

    <!-- Partie droite - Formulaire -->
    <div class="right-side">
        <div class="login-card">
            
            <div class="login-header">
                <h1>Bienvenue</h1>
                <p>Connectez-vous pour accéder à votre espace</p>
            </div>

            <!-- Messages d'erreur -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Formulaire -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-envelope"></i>
                        Adresse email
                    </label>
                    <div class="input-wrapper">
                        <i class="bi bi-person"></i>
                        <input type="email" 
                               name="email" 
                               class="form-input"
                               placeholder="exemple@ujkz.bf"
                               value="{{ old('email') }}"
                               required 
                               autofocus>
                    </div>
                </div>

                <!-- Mot de passe -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-lock"></i>
                        Mot de passe
                    </label>
                    <div class="input-wrapper">
                        <i class="bi bi-key"></i>
                        <input type="password" 
                               id="password"
                               name="password" 
                               class="form-input"
                               placeholder="••••••••"
                               required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <!-- Options -->
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Se souvenir de moi</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <!-- Bouton de connexion -->
                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Se connecter</span>
                </button>

            </form>

            <!-- Footer -->
            <div class="footer-text">
                <p>© {{ date('Y') }} UJKZ - Tous droits réservés</p>
            </div>

        </div>
    </div>

</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
}
</script>

</body>
</html>