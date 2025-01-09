<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f54ea2, #ff7676);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .error-container {
            max-width: 600px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .error-container h1 {
            font-size: 6rem;
            margin-bottom: 20px;
        }

        .error-container p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .btn-home {
            text-decoration: none;
            color: #fff;
            background: #ff7676;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .btn-home:hover {
            background: #f54ea2;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>404</h1>
        <p>Oops! La page que vous cherchez est introuvable.</p>
        <a href="../Classes/Role.php" class="btn-home">Retour à l'accueil</a>
    </div>
</body>
</html>
