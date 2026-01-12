<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - DataCenter Manager</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 480px;
            width: 100%;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 40px 32px 40px;
            text-align: center;
            color: white;
        }

        .icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .form-content {
            padding: 32px;
        }

        .info-box {
            background: linear-gradient(135deg, #f0f4ff 0%, #e6edff 100%);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 24px;
            border-left: 3px solid #667eea;
        }

        .info-box p {
            font-size: 13px;
            color: #4a5568;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 6px;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f7fafc;
        }

        input[type="email"]:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .error-message {
            color: #e53e3e;
            background: #fff5f5;
            border: 1px solid #feb2b2;
            border-radius: 8px;
            padding: 12px;
            margin-top: 8px;
            font-size: 14px;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .header {
                padding: 32px 24px;
            }

            .header h1 {
                font-size: 24px;
            }

            .form-content {
                padding: 24px;
            }

            .icon {
                width: 64px;
                height: 64px;
                font-size: 32px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div class="icon">💻</div>
        <h1>DataCenter Manager</h1>
        <p>Réinitialisation du mot de passe</p>
    </div>

    <div class="form-content">
        <div class="info-box">
            <p>Entrez votre adresse email pour recevoir les instructions de réinitialisation de votre mot de passe.</p>
        </div>

        <form method="POST" action="{{ url('/forgot-password-secret') }}">
            @csrf

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" placeholder="ouis2004@datacenter.ma" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">Continuer</button>
        </form>

        <div class="back-link">
            <a href="{{ url('/login') }}">← Retour à la connexion</a>
        </div>
    </div>
</div>

</body>
</html>