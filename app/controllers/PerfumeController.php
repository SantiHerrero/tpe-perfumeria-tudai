<?php
require_once __DIR__ . '/../models/PerfumeModel.php';
require_once __DIR__ . '/../models/LaboratorioModel.php';
require_once __DIR__ . '/Controller.php';

class PerfumeController extends Controller {
    private $model;
    private $labModel;

    public function __construct() {
        $this->model = new PerfumeModel();
        $this->labModel = new LaboratorioModel();
    }

    // === PUBLIC ===
    public function index() {
        $items = $this->model->all();
        $this->render('perfumes/list.phtml', ['items' => $items]);
    }

    public function show($id) {
        $item = $this->model->find($id);
        if (!$item) die("Perfume no encontrado");
        $this->render('perfumes/detail.phtml', ['item' => $item]);
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
        $items = $this->model->all();
        $this->render('admin/perfumes_list.phtml', ['items' => $items]);
    }

    public function createForm() {
        $this->checkAdmin();
        $labs = $this->labModel->all();
        $this->render('admin/perfume_form.phtml', ['labs' => $labs]);
    }

    public function create() {
        $this->checkAdmin();
        $this->model->create(
            $_POST['id_laboratorio'],
            $_POST['precio'],
            $_POST['codigo'],
            $_POST['duracion'],
            $_POST['aroma'],
            $_POST['sexo']
        );
        header('Location: ' . BASE_URL . '?action=admin/perfumes');
    }

    public function delete($id) {
        $this->checkAdmin();
        $this->model->delete($id);
        header('Location: ' . BASE_URL . '?action=admin/perfumes');
    }

    public function editForm($id) {
        $this->checkAdmin();
        $item = $this->model->find($id);
        $labs = $this->labModel->all();
        $this->render('admin/perfume_form.phtml', ['labs' => $labs, 'item' => $item]);
    }

    public function edit($id) {
        $this->checkAdmin();
        $this->model->update(
            $id,
            $_POST['id_laboratorio'],
            $_POST['precio'],
            $_POST['codigo'],
            $_POST['duracion'],
            $_POST['aroma'],
            $_POST['sexo']
        );
        header('Location: ' . BASE_URL . '?action=admin/perfumes');
    }
}
