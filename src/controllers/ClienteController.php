<?php
require_once __DIR__ . '/../models/ClienteModel.php';

class ClienteController {
    public function exibirConsultaClientes() {
        $clientes = ClienteModel::getAllClientes();
        include __DIR__ . '/../views/editar_clientes.php';
    }

    public function atualizarCliente() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_cliente = $_POST['id_cliente'];
            $email = $_POST['email'];
            $endereco = $_POST['endereco'];
            $telefone = $_POST['telefone'];
            $ativo = $_POST['ativo'];

            $resultado = ClienteModel::atualizarCliente($id_cliente, $email, $endereco, $telefone, $ativo);

            if ($resultado) {
                header('Location: index.php?page=editar_clientes&status=sucesso');
            } else {
                header('Location: index.php?page=editar_clientes&status=erro');
            }
            exit;
        }
    }
}
?>
