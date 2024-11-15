<!DOCTYPE html>
<html>
<head>
    <title>NIMVAL - Rastreamentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #00509e;
            background-image: url('images/nimval_logo.jpg'); 
            background-repeat: repeat; 
            background-size: 200px 100px; 
            color: #fff;
            position: relative;
        }

        .container {
            display: flex;
            gap: 20px;
            z-index: 1;
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
            color: #00509e;
        }

        .card:hover {
            transform: scale(1.05);
            background-color: rgba(0, 80, 158, 0);
            color: #fff;
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
            <p>Acesse aqui</p>
        </div>
        <div class="card" onclick="location.href='/Project_Nimval/src/views/login.php?perfil=fornecedor'">
            <h2>Fornecedor</h2>
            <p>Acesse aqui</p>
        </div>
    </div>
</body>
</html>
