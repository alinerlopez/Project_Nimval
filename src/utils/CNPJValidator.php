<?php

class CNPJValidator {
    // Função para validar o CNPJ via API Receitaws
    public static function validarCNPJ($cnpj) {
        // Remove os caracteres especiais
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // URL da API para consulta
        $url = "https://www.receitaws.com.br/v1/cnpj/" . $cnpj;

        // Faz a requisição à API Receitaws
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        // Verifica o status da resposta
        if (isset($data['status']) && $data['status'] == 'ERROR') {
            return false; // CNPJ inválido ou não encontrado
        }

        return $data; // Retorna os dados se o CNPJ for válido
    }
}
