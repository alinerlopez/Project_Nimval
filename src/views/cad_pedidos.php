<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/UserModel.php';

if (isset($_POST['cpf'])) {
    $cpf = $_POST['cpf'];
    $cliente = UserModel::findClientByCPF($cpf); 

    if ($cliente) {
        echo json_encode($cliente); 
    } else {
        echo json_encode(['error' => 'Cliente não encontrado']);
    }
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pedido</title>
    <style>
        body {
            display: flex;
            margin: 0;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        .content {
            flex-grow: 1;
            padding: 30px;
            background-color: #f8f9fa;
            overflow-y: auto;
        }

        .search-container input[type="text"] {
            width: 80%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-container button {
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        .client-card {
        background: linear-gradient(145deg, var(--azul-principal), var(--azul-claro));
        color: #fff;
        padding: 20px;
        width: 90%;
        max-width: 400px;
        margin: 20px auto;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); 
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        text-align: center;
    }

    .client-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); 
    }

    .client-card h3 {
        font-size: 1.6em;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .client-card p {
        font-size: 1em;
        margin: 5px 0;
    }

    .client-card .btn {
        padding: 12px 20px;
        font-size: 16px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 15px;
        cursor: pointer;
        margin-top: 20px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .client-card .btn:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    .client-card .btn:active {
        background-color: #1e7e34;
        transform: scale(0.98);
    }

    /* Responsividade */
    @media (max-width: 600px) {
        .client-card {
            width: 100%;
            padding: 15px;
        }
    }
    .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            padding-left: 30px;
            padding-right: 30px;
            border: 1px solid #888;
            border-radius: 8px;
            width: 400px; 
            max-width: 40%; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .modal-content label {
            display: block;
            margin-top: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        .modal-content input,
        .modal-content select,
        .modal-content button {
            font-size: 12px;
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            margin-bottom: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .modal-content button {
            background-color: #007bff;
            color: #fff;
            border: none;
            font-size: 14px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }
        .modal-content h3 {
        font-size: 1.8em;
        color: #333;
        margin-bottom: 20px;
        font-weight: 600;
        text-align: center;
    }
    .modal-content textarea {
        font-size: 14px;
        padding: 12px;
        width: 100%;
        margin-bottom: 15px;
        border-radius: 6px;
        border: 1px solid #ccc;
        resize: vertical; /* Permite que o usuário redimensione a altura */
        box-sizing: border-box;
        transition: all 0.3s ease;
    }
    .modal-content textarea:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
    }

    /* Estilo do campo de data (sem hora) */
    .modal-content input[type="date"] {
        font-size: 14px;
        padding: 12px;
        width: 100%;
        margin-bottom: 15px;
        border-radius: 6px;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .modal-content input[type="date"]:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
    }

    </style>
</head>
<body>
<?php include __DIR__ . '/../utils/sidebar_fornecedor.php'; ?>
<div class="content">
    <h2>Cadastro de Pedido</h2>

    <div class="search-container">
        <input type="text" id="cpf" placeholder="Digite o CPF do cliente" maxlength="14">
        <button onclick="buscarCliente()">Buscar</button>
    </div>

    <div id="clienteEncontrado" style="display: none;">
    <div class="client-card">
        <h3 id="clientName"></h3>
        <p><strong>CPF:</strong> <span id="clientCpf"></span></p>
        <p><strong>Email:</strong> <span id="clientEmail"></span></p>
        <button class="btn" onclick="openPedidoForm()">Cadastrar Pedido</button>
    </div>
</div>

   
<div id="pedidoModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePedidoForm()">&times;</span>
        <h3 id="modalTitle">Cadastrar Pedido para <span id="clienteNome"></span></h3>

        <form action="../views/cad_pedidos.php" method="post">
            <input type="hidden" id="id_cliente" name="id_cliente">

            <label for="numeroPedido">Número do Pedido:</label>
            <input type="number" id="num_pedido" name="num_pedido">
            
            <label for="descricao">Descrição do Pedido:</label>
            <textarea id="descricao" name="descricao_pedido" rows="6" required></textarea>

            <label for="data_pedido">Data do Pedido:</label>
            <input type="date" id="data_pedido" name="data_pedido" required>

            <button type="submit" class="btn">Cadastrar Pedido</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
       $(document).ready(function() {
    $('#cpf').mask('000.000.000-00');
    setTimeout(function() {
        $('#error-message').fadeOut('slow');
        $('#success-message').fadeOut('slow');
    }, 800);
});

function buscarCliente() {
    const cpf = document.getElementById('cpf').value;

    if (cpf.length === 14) {
        const formData = new FormData();
        formData.append('cpf', cpf); 

        fetch('../src/views/cad_pedidos.php', {  
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) 
        .then(data => {
            console.log('Dados recebidos:', data);  

            if (data.error) {
                alert(data.error);
                document.getElementById('clienteEncontrado').style.display = 'none';
            } else {
                document.getElementById('clientName').innerText = data.nome;
                document.getElementById('clientCpf').innerText = data.cpf; 
                document.getElementById('clientEmail').innerText = data.email;
                document.getElementById('clienteEncontrado').style.display = 'block';
                document.getElementById('id_cliente').value = data.id_cliente;
            }
        })
        .catch(error => console.error('Erro ao buscar cliente:', error));
    } else {
        alert('Por favor, insira um CPF válido.');
    }
}

    function openPedidoForm() {
        const clienteNome = document.getElementById('clientName').innerText;
        document.getElementById('clienteNome').innerText = clienteNome;
        document.getElementById('pedidoModal').style.display = 'block';
    }

    function closePedidoForm() {
        document.getElementById('pedidoModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('pedidoModal')) {
            closePedidoForm();
        }
    }
</script>

</body>
</html>
