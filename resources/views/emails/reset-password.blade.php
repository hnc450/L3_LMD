<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(to right, #1e3a8a, #06b6d4);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(to right, #1e3a8a, #06b6d4);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Plateforme de Gestion des Plaintes</h1>
        </div>
        <div class="content">
            <h2>Réinitialisation du mot de passe</h2>
            <p>Vous recevez cet email car nous avons reçu une demande de réinitialisation du mot de passe pour votre compte.</p>
            
            <div style="text-align: center;">
                <a href="{{ $url }}" class="button">Réinitialiser le mot de passe</a>
            </div>
            
            <p>Ce lien de réinitialisation expirera dans 60 minutes.</p>
            
            <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune autre action n'est requise.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Plateforme de Gestion des Plaintes. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
