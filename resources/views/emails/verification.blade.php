<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de compte</title>
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
            <h2>Bonjour {{ $user->name }},</h2>
            <p>Merci de vous être inscrit sur notre plateforme. Pour activer votre compte, veuillez vérifier votre adresse email en cliquant sur le bouton ci-dessous :</p>
            
            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="button">Vérifier mon email</a>
            </div>
            
            <p>Si vous n'avez pas créé de compte, vous pouvez ignorer cet email.</p>
            
            <p>Ce lien expirera dans 60 minutes.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Plateforme de Gestion des Plaintes. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
