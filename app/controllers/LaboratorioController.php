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
        require_once __DIR__ . '/../models/PerfumeModel.php';
        $perfModel = new PerfumeModel();
        $lab = $this->model->find($id);
        $items = $perfModel->byLaboratorio($id);
        $this->render('laboratorios/perfumes_by_lab.phtml', ['items' => $items, 'lab' => $lab]);
    }

    // === ADMIN ===
    private function checkAdmin() {
        session_start();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: ' . BASE_URL . '?action=login');
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
        $this->model->create(
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['url'],
            $_POST['fundador'],
            $_POST['pais']
        );
        header('Location: ' . BASE_URL . '?action=admin/laboratorios');
    }

    public function delete($id) {
        $this->checkAdmin();
        $this->model->delete($id);
        header('Location: ' . BASE_URL . '?action=admin/laboratorios');
    }

    public function editForm($id) {
        $this->checkAdmin();
        $lab = $this->model->find($id);
        $this->render('admin/laboratorio_form.phtml', ['lab' => $lab]);
    }

    public function edit($id) {
        $this->checkAdmin();
        $this->model->update(
            $id,
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['url'],
            $_POST['fundador'],
            $_POST['pais']
        );
        header('Location: ' . BASE_URL . '?action=admin/laboratorios');
    }
}
