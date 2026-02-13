<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Création de votre compte</title>
</head>
<body>
    <p>Bonjour {{ $user->nom_utilisateur }} {{ $user->prenom_utilisateur }}, matricule {{ $user->matricule_utilisateur }}</p>

    <p>Votre compte a été créé avec succès.</p>

    <p>
        <strong>Identifiant :</strong> {{ $user->email }}<br>
        <strong>Mot de passe temporaire :</strong> {{ $password }}
    </p>

    <p>
        Veuillez vous connecter via le lien ci-dessous et modifier votre profil dans l'onglet profil :
    </p>

    <p>
        <a href="{{ url('/login') }}">{{ url('/login') }}</a>
    </p>

    <p>Merci.</p>
</body>
</html>
