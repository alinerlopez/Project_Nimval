<?php
require_once __DIR__ . '/../models/UserModel.php'; 

class AuthController {

    public function validarEmail() {
        if (isset($_GET['token']) && !empty($_GET['token'])) {
            $token = htmlspecialchars($_GET['token']); 
            try {
                $valido = UserModel::verificarTokenValidacao($token);

                if ($valido) {
                    UserModel::validarEmail($token);
                    header('Location: index.php?page=login&email_validado=true');
                    exit();
                } else {
                    header('Location: index.php?page=login&email_validado=false');
                    exit();
                }
            } catch (Exception $e) {
                error_log("Erro ao validar e-mail: " . $e->getMessage());
                header('Location: index.php?page=login&email_validado=false');
                exit();
            }
        } else {
            header('Location: index.php?page=login&email_validado=false');
            exit();
        }
    }
}
?>
