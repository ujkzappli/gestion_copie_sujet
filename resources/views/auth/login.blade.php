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
            overflow: hidden;
        }

        /* Formes décoratives subtiles */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #667eea15, #764ba215);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            z-index: 0;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #667eea10, #764ba210);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            z-index: 0;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            margin: auto;
            position: relative;
            z-index: 1;
        }

        /* Partie gauche - Illustration */
        .left-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 0 30px 30px 0;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
        }

        .logo-container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }

        .logo-container img {
            max-width: 200px;
            height: auto;
            display: block;
        }

        .illustration-text {
            color: white;
            text-align: center;
        }

        .illustration-text h2 {
            font-size: 2rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .illustration-text p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 30px;
            width: 100%;
            max-width: 400px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.1);
            padding: 12px 20px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .feature-item i {
            font-size: 1.5rem;
        }

        /* Partie droite - Formulaire */
        .right-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h1 {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .login-header p {
            color: #6c757d;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-label i {
            color: #667eea;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.1rem;
        }

        .form-input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 1.1rem;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .forgot-password {
            font-size: 0.9rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger {
            background: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 30px 0;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e9ecef;
        }

        .footer-text {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .container {
                flex-direction: column;
            }

            .left-side {
                border-radius: 30px 30px 0 0;
                padding: 40px 30px;
            }

            .left-side .illustration-text h2 {
                font-size: 1.5rem;
            }

            .features {
                display: none;
            }

            .right-side {
                padding: 40px 30px;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .logo-container img {
                max-width: 150px;
            }

            .right-side {
                padding: 30px 20px;
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
            <h2>Système de Gestion des Copies de l'Université Joseph KI-ZERBO</h2>
            <p></p>
        </div>

        <div class="features">
            <div class="feature-item">
                <i class="bi bi-shield-check"></i>
                <span>Connexion sécurisée</span>
            </div>
            <div class="feature-item">
                <i class="bi bi-speedometer2"></i>
                <span>Interface rapide et moderne</span>
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
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Se connecter
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