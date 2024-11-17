<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acompanhar Pedido</title>
    <link href="/Project_Nimval/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/colors.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            margin: 0;
            background-color: var(--gelo);
        }

        .btn-back {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--azul-principal);
            font-size: 12px;
            margin-bottom: 4px;
        }

        .btn-back:hover {
            color: var(--azul-escuro);
        }

        .btn-back i {
            font-size: 30px;
        }

        .header-section {
            text-align: center;
            margin-top: 4px;
            margin-bottom: 30px;
        }

        .header-section h2 {
            color: var(--cinza-escuro);
        }

        .card-pedido {
            background-color: var(--branco);
            border: 1px solid var(--cinza-borda);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-pedido h5 {
            color: var(--azul-principal);
            margin-bottom: 10px;
        }

        .timeline-container {
            position: relative;
            padding: 0 20px;
        }

        .timeline-container:before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: var(--cinza-claro2);
        }

        .timeline-item {
            display: flex;
            align-items: flex-start;
            position: relative;
            margin-bottom: 20px;
            padding-left: 40px;
        }

        .timeline-point {
            position: absolute;
            left: 10px;
            top: 10px;
            width: 20px;
            height: 20px;
            background-color: var(--azul-principal);
            border: 3px solid var(--branco);
            border-radius: 50%;
            z-index: 2;
        }

        .timeline-point.active {
            background-color: var(--alerta-sucesso);
        }

        .timeline-content {
            background-color: var(--branco);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid var(--cinza-borda);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
        }

        .timeline-date {
            font-size: 14px;
            color: var(--cinza-medio);
            margin-bottom: 5px;
        }

        .timeline-status {
            font-size: 16px;
            font-weight: bold;
            color: var(--azul-principal);
        }

        @media (max-width: 768px) {
            .timeline-container:before {
                left: 15px;
            }
            .timeline-item {
                padding-left: 30px;
            }
            .timeline-point {
                left: 5px;
            }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../utils/header_cliente.php'; ?>

    <div class="container">
        <div>
            <a href="index.php?page=meus_pedidos" class="btn-back">
                <i class="bi bi-arrow-left-circle"></i>
            </a>
        </div>
        <div class="header-section">
            <h2 class="mb-0">Rastreamento do Pedido</h2>
        </div>

        <div class="card-pedido">
            <h5>Pedido #<?= htmlspecialchars($pedido['numero_pedido']); ?></h5>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($pedido['descricao_pedido']); ?></p>
            <p><strong>Data do Pedido:</strong> <?= htmlspecialchars($pedido['data_pedido']); ?></p>
            <p><strong>Status Atual:</strong> <?= htmlspecialchars($pedido['status_pedido']); ?></p>
        </div>

        <div class="timeline-container">
            <?php foreach ($historico_status as $index => $status): ?>
                <div class="timeline-item">
                    <span class="timeline-point <?= $index === array_key_last($historico_status) ? 'active' : ''; ?>"></span>
                    <div class="timeline-content">
                        <div class="timeline-date"><?= htmlspecialchars(date("d/m/Y H:i", strtotime($status['data_modificacao']))); ?></div>
                        <div class="timeline-status"><?= htmlspecialchars($status['status_pedido']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
