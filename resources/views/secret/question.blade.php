<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question secrète - DataCenter Manager</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: rgba(255, 255, 255, 0.1);;
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
            max-width: 560px;
            width: 100%;
            overflow: hidden;
        }

        .header {
            background: rgba(255, 255, 255, 0.15);
            padding: 48px 40px;
            text-align: center;
            color: white;
        }

        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 15px;
            opacity: 0.9;
        }

        .form-content {
            padding: 40px;
        }

        .question-box {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 32px;
            border-left: 4px solid #2f3a6bff;
        }

        .question-label {
            font-size: 13px;
            font-weight: 600;
            color: #2f3a6bff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .question-text {
            font-size: 16px;
            color: #2f3a6bff;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #2f3a6bff;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f7fafc;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #4c5682ff;
            background: rgba(255, 255, 255, 0.1);
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
            padding: 16px;
            background: linear-gradient(135deg, #2f3a6bff 0%, #2f3a6bff 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 32px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
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
        <div class="icon">🔐</div>
        <h1>DataCenter Manager</h1>
        <p>Réinitialisation du mot de passe</p>
    </div>

    <div class="form-content">
        <div class="question-box">
            <div class="question-label">Question secrète</div>
            <div class="question-text">{{ $user->secret_question }}</div>
        </div>

        <form method="POST" action="{{ route('secret.reset') }}">
            @csrf

            <div class="form-group">
                <label for="secret_answer">Réponse</label>
                <input type="text" id="secret_answer" name="secret_answer" required>
                @error('secret_answer')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="submit-btn">Réinitialiser le mot de passe</button>
        </form>
    </div>
</div>

</body>
</html>