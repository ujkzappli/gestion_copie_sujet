<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #43cea2, #185a9d);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, sans-serif;
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
            margin-bottom: 30px;
        }

        input {
            width: 100%;
            padding: 14px;
            margin-bottom: 18px;
            border-radius: 10px;
            border: none;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: #fff;
            color: #185a9d;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            color: #fff;
            text-decoration: underline;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>Create account ✨</h1>

    @if ($errors->any())
        <div style="background:red; padding:10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="text" name="nom_utilisateur" placeholder="Nom" required>
        <input type="text" name="prenom_utilisateur" placeholder="Prénom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="matricule_utilisateur" placeholder="Matricule" required>

        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="password" name="password_confirmation" placeholder="Confirmation" required>

        {{-- TYPE --}}
        <select
            id="type"
            name="type"
            required
            onchange="handleTypeChange()"
            style="width:100%; padding:14px; margin-bottom:18px; border-radius:10px; border:none; font-size:15px;"
        >
            <option value="">Type de compte</option>
            <option value="DA">DA</option>
            <option value="CS">CS</option>
            <option value="CD">CD</option>
            <option value="Enseignant">Enseignant</option>
            <option value="Admin">Admin</option>
            <option value="President">President</option>
        </select>

        {{-- ETABLISSEMENT --}}
        <div id="etablissement-field" style="display:none;">
            <input
                type="number"
                name="etablissement_id"
                placeholder="Établissement ID"
            >
        </div>

        {{-- DEPARTEMENT --}}
        <div id="departement-field" style="display:none;">
            <input
                type="number"
                name="departement_id"
                placeholder="Département ID"
            >
        </div>

        <button>S'inscrire</button>
    </form>


    <div class="footer">
        Déjà inscrit ?
        <a href="{{ route('login') }}">Se connecter</a>
    </div>
</div>

</body>
<script>
function handleTypeChange() {
    const type = document.getElementById('type').value;

    const etablissement = document.getElementById('etablissement-field');
    const departement = document.getElementById('departement-field');

    const etablissementInput = etablissement.querySelector('input');
    const departementInput = departement.querySelector('input');

    // reset
    etablissement.style.display = 'none';
    departement.style.display = 'none';
    etablissementInput.required = false;
    departementInput.required = false;

    if (type === 'DA' || type === 'CS') {
        etablissement.style.display = 'block';
        etablissementInput.required = true;
    }

    if (type === 'CD') {
        etablissement.style.display = 'block';
        departement.style.display = 'block';
        etablissementInput.required = true;
        departementInput.required = true;
    }

    if (type === 'Enseignant') {
        departement.style.display = 'block';
        departementInput.required = true;
    }
}
</script>


</html>
