<?php
require_once '../app/controllers/PerfumeController.php';
require_once '../app/controllers/LaboratorioController.php';
require_once '../app/controllers/AuthController.php';

$action = $_GET['action'] ?? 'perfumes';
$params = explode('/', $action);

switch ($params[0]) {
    case 'perfumes':
        (new PerfumeController())->showAll();
        break;
    case 'perfume':
        (new PerfumeController())->show($params[1]);
        break;
    case 'laboratorios':
        (new LaboratorioController())->showAll();
        break;
    case 'laboratorio':
        (new LaboratorioController())->showPerfumes($params[1]);
        break;
    case 'login':
        (new AuthController())->login();
        break;
    case 'logout':
        (new AuthController())->logout();
        break;
    case 'admin/perfumes/create':
        (new PerfumeController())->adminCreateSubmit();
        break;
    default:
        echo "404 Not Found";
}