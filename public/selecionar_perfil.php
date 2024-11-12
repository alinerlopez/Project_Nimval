<!DOCTYPE html>
<html>
<head>
    <title>Seleção de Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }
        .container {
            display: flex;
            gap: 20px;
        }
        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 200px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card h2 {
            margin: 0 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card" onclick="location.href='/Project_Nimval/src/views/login.php?perfil=cliente'">
            <h2>Cliente</h2>
            <p>Acesse como cliente</p>
        </div>
        <div class="card" onclick="location.href='/Project_Nimval/src/views/login.php?perfil=fornecedor'">
            <h2>Fornecedor</h2>
            <p>Acesse como fornecedor</p>
        </div>
    </div>
</body>
</html>
