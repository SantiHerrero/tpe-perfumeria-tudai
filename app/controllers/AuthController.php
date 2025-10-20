<?php
require_once __DIR__ . '/../models/UsuarioModel.php';
class AuthController {
    private $model;
    public function __construct(){ $this->model = new UsuarioModel(); }
    public function login(){
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $u = $_POST['username'] ?? '';
            $p = $_POST['password'] ?? '';
            $user = $this->model->getByUsername($u);
            if ($user && password_verify($p, $user['contrasenia'])) {
                $_SESSION['USER_ID'] = $user['id'];
                $_SESSION['USER_NAME'] = $user['nombre_usuario'];
                header('Location: '.BASE_URL.'?action=admin/perfumes');
                exit;
            } else {
                $error = 'Credenciales invalidas';
                require __DIR__ . '/../views/templates/header.phtml';
                require __DIR__ . '/../views/auth/login.phtml';
                require __DIR__ . '/../views/templates/footer.phtml';
                return;
            }
        }
        require __DIR__ . '/../views/templates/header.phtml';
        require __DIR__ . '/../views/auth/login.phtml';
        require __DIR__ . '/../views/templates/footer.phtml';
    }
    public function logout(){
        session_start();
        session_destroy();
        header('Location: '.BASE_URL.'?action=perfumes');
    }
}
