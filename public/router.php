<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../app/db/init_db.php';
require_once __DIR__ . '/../app/controllers/PerfumeController.php';
require_once __DIR__ . '/../app/controllers/LaboratorioController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

function show404() {
    http_response_code(404);
    require __DIR__ . '/../app/views/templates/header.phtml';
    require __DIR__ . '/../app/views/errors/404.phtml';
    require __DIR__ . '/../app/views/templates/footer.phtml';
    exit;
}

$action = $_GET['action'] ?? 'perfumes';
$params = explode('/', trim($action, '/'));

// Router principal
switch ($params[0]) {
    case 'perfumes':
        $controller = new PerfumeController();
        isset($params[1]) ? $controller->show($params[1]) : $controller->index();
        break;

    case 'perfume':
        (new PerfumeController())->show($params[1] ?? null);
        break;

    case 'laboratorios':
        $controller = new LaboratorioController();
        isset($params[1]) ? $controller->showPerfumes($params[1]) : $controller->index();
        break;

    case 'login':
        (new AuthController())->login();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'admin':
        if (!isset($params[1])) show404();
        switch ($params[1]) {
            case 'perfumes':
                $ctrl = new PerfumeController();
                $op = $params[2] ?? null;
                $id = $params[3] ?? null;
                switch ($op) {
                    case null:         $ctrl->adminList(); break;
                    case 'createForm': $ctrl->createForm(); break;
                    case 'create':     $ctrl->create(); break;
                    case 'editForm':   $ctrl->editForm($id); break;
                    case 'edit':       $ctrl->edit($id); break;
                    case 'delete':     $ctrl->delete($id); break;
                    default:           show404(); break;
                }
                break;

            case 'laboratorios':
                $ctrl = new LaboratorioController();
                $op = $params[2] ?? null;
                $id = $params[3] ?? null;
                switch ($op) {
                    case null:         $ctrl->adminList(); break;
                    case 'createForm': $ctrl->createForm(); break;
                    case 'create':     $ctrl->create(); break;
                    case 'editForm':   $ctrl->editForm($id); break;
                    case 'edit':       $ctrl->edit($id); break;
                    case 'delete':     $ctrl->delete($id); break;
                    default:           show404(); break;
                }
                break;

            default:
                show404();
                break;
        }
        break;

    default:
        show404();
        break;
}
