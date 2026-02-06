<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', system-ui, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 18px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            color: #fff;
            box-shadow: 0 20px 40px rgba(0,0,0,.2);
        }

        h1 {
            text-align: center;
            margin-bottom: 8px;
        }

        p {
            text-align: center;
            opacity: .8;
            margin-bottom: 30px;
        }

        label {
            font-size: 14px;
            opacity: .9;
        }

        input {
            width: 100%;
            padding: 14px;
            margin-top: 6px;
            margin-bottom: 20px;
            border-radius: 10px;
            border: none;
            outline: none;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: #fff;
            color: #764ba2;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,.2);
        }

        .error {
            background: rgba(255, 0, 0, .2);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .footer a {
            color: #fff;
            font-weight: 600;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>Welcome back 👋</h1>
    <p>Connectez-vous à votre espace</p>

    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Mot de passe</label>
        <input type="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>

   
</div>

</body>
</html>
