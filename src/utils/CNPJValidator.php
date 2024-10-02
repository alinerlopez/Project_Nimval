<?php

class CNPJValidator {
    public static function validarCNPJ($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        $url = "https://www.receitaws.com.br/v1/cnpj/" . $cnpj;
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        if (isset($data['status']) && $data['status'] == 'ERROR') {
            return false; 
        }
        return $data; 
    }
}
