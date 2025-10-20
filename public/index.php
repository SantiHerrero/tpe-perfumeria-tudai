<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../app/db/init_db.php';
require_once __DIR__ . '/../app/controllers/PerfumeController.php';
require_once __DIR__ . '/../app/controllers/LaboratorioController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$path = $_GET['action'] ?? 'perfumes';
$parts = explode('/', trim($path, '/'));

$main = $parts[0] ?? 'perfumes';
$id = $parts[1] ?? null;

switch ($main) {
    case 'perfumes': (new PerfumeController())->index(); break;
    case 'perfume': (new PerfumeController())->show($id); break;
    case 'laboratorios': (new LaboratorioController())->index(); break;
    case 'laboratorio': (new LaboratorioController())->showPerfumes($id); break;
    case 'admin': 
        $sub = $parts[1] ?? 'perfumes';
        if ($sub === 'perfumes') (new PerfumeController())->adminList();
        elseif ($sub === 'laboratorios') (new LaboratorioController())->adminList();
        else echo 'Admin 404';
        break;
    case 'login': (new AuthController())->login(); break;
    case 'logout': (new AuthController())->logout(); break;
    default: http_response_code(404); echo '404'; break;
}
