<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../utils/session_helper.php';
verificarSessao('id_fornecedor');

if (isset($_POST['identificacao'])) {
    $identificacao = trim($_POST['identificacao']); 
    error_log("Identificação recebida: $identificacao");

    $cliente = UserModel::findClientByIdentificacao($identificacao);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pedido</title>
    <link href="/Project_Nimval/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            margin: 0;
            height: 100vh;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
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
        resize: vertical;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }
    .modal-content textarea:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
    }

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
    .alert {
    position: fixed; 
    top: 20px; 
    left: 50%; 
    transform: translateX(-50%); 
    z-index: 1050; 
    padding: 15px 25px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.5s ease-out;
    width: 90%; 
    max-width: 400px;
    text-align: center;
}
#tipo_documento {
        width: 80px; 
        padding: 8px; 
        font-size: 12px; 
        font-family: Arial, sans-serif; 
        color: #333; 
        background-color: #f8f9fa; 
        border: 2px solid #007bff; 
        border-radius: 8px; /
        appearance: none; 
        cursor: pointer; 
        transition: all 0.3s ease; 
    }

    #tipo_documento:hover {
        background-color: #e9ecef; 
        border-color: #0056b3; 
    }

    #tipo_documento:focus {
        outline: none; 
        border-color: #0056b3; 
        box-shadow: 0 0 5px rgba(0, 91, 187, 0.5); 
    }

    </style>
</head>
<body>
<?php include __DIR__ . '/../utils/sidebar_fornecedor.php'; ?>

<div class="content">
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center" id="error-message">
            <?= htmlspecialchars($_SESSION['error']); ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center" id="success-message">
            <?= htmlspecialchars($_SESSION['success']); ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <h2 class="text-center mb-4">Cadastro de Pedido</h2>
    <div class="search-container">
    <label for="tipo_documento">Tipo de Documento:</label>
    <select id="tipo_documento">
        <option value="cpf">CPF</option>
        <option value="cnpj">CNPJ</option>
    </select>
    <input type="text" id="documento" placeholder="Digite o CPF ou CNPJ do cliente" maxlength="18">
    <button id="buscarCliente" onclick="buscarCliente()">Buscar</button>
</div>
    <div id="clienteEncontrado" style="display: none;">
        <div class="client-card">
            <h3 id="clientName"></h3>
            <p><strong>CPF/CNPJ:</strong> <span id="clientCpfCnpj"></span></p>
            <p><strong>Email:</strong> <span id="clientEmail"></span></p>
            <a href="javascript:void(0);" class="btn" onclick="openPedidoForm()">Cadastrar Pedido</a>
        </div>
    </div>
    </div>

    <div id="pedidoModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePedidoForm()">&times;</span>
            <h3 id="modalTitle">Cadastrar Pedido para <span id="clienteNome"></span></h3>

            <form action="index.php?page=cadastrar_pedido" method="post">
                <input type="hidden" id="id_cliente" name="id_cliente">

                <label for="numeroPedido">Número do Pedido:</label>
                <input type="text" id="num_pedido" name="num_pedido" required>

                <label for="descricao">Descrição do Pedido:</label>
                <textarea id="descricao" name="descricao_pedido" rows="6" maxlength="180" required></textarea>

                <label for="data_pedido">Data do Pedido:</label>
                <input type="date" id="data_pedido" name="data_pedido" required>

                <button type="submit" class="btn">Cadastrar Pedido</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function () {
        const documentoInput = $('#documento');
        const tipoDocumento = $('#tipo_documento');

        function aplicarMascara() {
            const tipo = tipoDocumento.val();
            if (tipo === 'cpf') {
                documentoInput.mask('000.000.000-00', { reverse: true });
            } else if (tipo === 'cnpj') {
                documentoInput.mask('00.000.000/0000-00', { reverse: true });
            }
        }

        aplicarMascara();
        tipoDocumento.change(aplicarMascara);
    })

    function buscarCliente() {
    const identificacao = $('#documento').val();

    if (identificacao.length === 14 || identificacao.length === 18) {
        $.ajax({
            url: '/Project_Nimval/src/views/cad_pedidos.php',
            method: 'POST',
            data: { identificacao: identificacao },
            success: function(data) {
                try {
                    const jsonData = JSON.parse(data);
                    if (jsonData.error) {
                        alert(jsonData.error);
                        $('#clienteEncontrado').hide();
                    } else {
                        $('#clientName').text(jsonData.nome);
                        $('#clientCpfCnpj').text(jsonData.identificacao);
                        $('#clientEmail').text(jsonData.email);
                        $('#clienteEncontrado').show();
                        $('#id_cliente').val(jsonData.id_cliente);
                    }
                } catch (error) {
                    console.error('Erro ao processar resposta JSON:', error);
                    alert('Erro ao processar a resposta do servidor.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro ao fazer a requisição AJAX:', error);
                alert('Erro ao buscar o cliente.');
            }
        });
    } else {
        alert('Por favor, insira um CPF ou CNPJ válido.');
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

    window.onclick = function (event) {
        const modal = document.getElementById('pedidoModal');
        if (event.target === modal) {
            closePedidoForm();
        }
    };
</script>

<script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
