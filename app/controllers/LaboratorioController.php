<?php
require_once __DIR__ . '/../models/LaboratorioModel.php';
require_once __DIR__ . '/Controller.php';

class LaboratorioController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new LaboratorioModel();
    }

    // === PUBLIC ===
    public function index() {
        $labs = $this->model->all();
        $this->render('laboratorios/list.phtml', ['labs' => $labs]);
    }

    public function showPerfumes($id) {
        if (empty($id) || !is_numeric($id)) {
            $this->render('errors/404.phtml', ['message' => 'Laboratorio inválido']);
            return;
        }

        require_once __DIR__ . '/../models/PerfumeModel.php';
        $perfModel = new PerfumeModel();

        $lab = $this->model->find($id);
        if (!$lab) {
            $this->render('errors/404.phtml', ['message' => 'Laboratorio no encontrado']);
            return;
        }

        $items = $perfModel->byLaboratorio($id);
        $this->render('laboratorios/perfumes_by_lab.phtml', [
            'items' => $items,
            'lab' => $lab
        ]);
    }

    // === ADMIN ===
    private function checkAdmin() {
        session_start();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
    }

    public function adminList() {
        $this->checkAdmin();
        $labs = $this->model->all();
        $this->render('admin/laboratorios_list.phtml', ['labs' => $labs]);
    }

    public function createForm() {
        $this->checkAdmin();
        $this->render('admin/laboratorio_form.phtml');
    }

    public function create() {
        $this->checkAdmin();

        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $url = trim($_POST['url'] ?? '');
        $fundador = trim($_POST['fundador'] ?? '');
        $pais = trim($_POST['pais'] ?? '');

        if (empty($nombre) || empty($descripcion) || empty($url) || empty($fundador) || empty($pais)) {
            $error = 'Todos los campos son obligatorios.';
            $this->render('admin/laboratorio_form.phtml', ['error' => $error]);
            return;
        }

        $this->model->create($nombre, $descripcion, $url, $fundador, $pais);
        header('Location: ' . BASE_URL . 'admin/laboratorios');
    }

    public function delete($id) {
        $this->checkAdmin();

        if (empty($id) || !is_numeric($id)) {
            $this->render('errors/404.phtml', ['message' => 'ID inválido']);
            return;
        }

        $lab = $this->model->find($id);
        if (!$lab) {
            $this->render('errors/404.phtml', ['message' => 'Laboratorio no encontrado']);
            return;
        }

        $this->model->delete($id);
        header('Location: ' . BASE_URL . 'admin/laboratorios');
    }

    public function editForm($id) {
        $this->checkAdmin();
        if (empty($id) || !is_numeric($id)) {
            $this->render('errors/404.phtml', ['message' => 'ID inválido']);
            return;
        }

        $lab = $this->model->find($id);
        if (!$lab) {
            $this->render('errors/404.phtml', ['message' => 'Laboratorio no encontrado']);
            return;
        }

        $this->render('admin/laboratorio_form.phtml', ['lab' => $lab]);
    }

    public function edit($id) {
        $this->checkAdmin();

        if (empty($id) || !is_numeric($id)) {
            $this->render('errors/404.phtml', ['message' => 'ID inválido']);
            return;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $url = trim($_POST['url'] ?? '');
        $fundador = trim($_POST['fundador'] ?? '');
        $pais = trim($_POST['pais'] ?? '');

        if (empty($nombre) || empty($descripcion) || empty($url) || empty($fundador) || empty($pais)) {
            $error = 'Todos los campos son obligatorios.';
            $lab = $this->model->find($id);
            $this->render('admin/laboratorio_form.phtml', ['lab' => $lab, 'error' => $error]);
            return;
        }

        $lab = $this->model->find($id);
        if (!$lab) {
            $this->render('errors/404.phtml', ['message' => 'Laboratorio no encontrado']);
            return;
        }

        $this->model->update($id, $nombre, $descripcion, $fundador, $url, $pais);
        header('Location: ' . BASE_URL . 'admin/laboratorios');
    }
}
