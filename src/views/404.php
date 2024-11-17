<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada</title>
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/colors.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: var(--gelo);
            color: var(--cinza-escuro);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 600px;
            padding: 20px;
            background-color: var(--branco);
            border: 1px solid var(--borda-clara);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 4rem;
            color: var(--azul-principal);
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            color: var(--cinza-medio2);
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            color: var(--branco);
            background-color: var(--azul-principal);
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: var(--azul-escuro);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p>Oops! A página que você está procurando não foi encontrada.</p>
        <a href="index.php" class="btn">Voltar para a página inicial</a>
    </div>
</body>
</html>
