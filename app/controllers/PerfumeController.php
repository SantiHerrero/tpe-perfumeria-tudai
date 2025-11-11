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
        if (empty($id) || !is_numeric($id)) {
            $this->render('errors/404.phtml', ['message' => 'ID inválido']);
            return;
        }

        $item = $this->model->find($id);
        if (!$item) {
            $this->render('errors/404.phtml', ['message' => 'Perfume no encontrado']);
            return;
        }

        $this->render('perfumes/detail.phtml', ['item' => $item]);
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

        $id_laboratorio = $_POST['id_laboratorio'] ?? '';
        $precio = $_POST['precio'] ?? '';
        $codigo = trim($_POST['codigo'] ?? '');
        $duracion = trim($_POST['duracion'] ?? '');
        $aroma = trim($_POST['aroma'] ?? '');
        $sexo = $_POST['sexo'] ?? 0;

        
        if (
            empty($id_laboratorio) || !is_numeric($id_laboratorio) ||
            empty($precio) || !is_numeric($precio) ||
            empty($codigo) || empty($duracion) ||
            empty($aroma) || !is_numeric($sexo)
        ) {
            $error = 'Todos los campos son obligatorios y deben ser válidos.';
            $labs = $this->labModel->all();
            $this->render('admin/perfume_form.phtml', [
                'labs' => $labs,
                'error' => $error,
                'values' => compact('id_laboratorio', 'precio', 'codigo', 'duracion', 'aroma', 'sexo')
            ]);
            return;
        }

        $lab = $this->labModel->find($id_laboratorio);
        if (!$lab) {
            $error = 'El laboratorio seleccionado no existe.';
            $labs = $this->labModel->all();
            $this->render('admin/perfume_form.phtml', [
                'labs' => $labs,
                'error' => $error
            ]);
            return;
        }

        $this->model->create($id_laboratorio, $precio, $codigo, $duracion, $aroma, $sexo);
        header('Location: ' . BASE_URL . 'admin/perfumes');
    }

    public function delete($id) {
        $this->checkAdmin();

        if (empty($id) || !is_numeric($id)) {
            $this->render('errors/404.phtml', ['message' => 'ID inválido']);
            return;
        }

        $item = $this->model->find($id);
        if (!$item) {
            $this->render('errors/404.phtml', ['message' => 'Perfume no encontrado']);
            return;
        }

        $this->model->delete($id);
        header('Location: ' . BASE_URL . 'admin/perfumes');
    }

    public function editForm($id) {
        $this->checkAdmin();

        if (empty($id) || !is_numeric($id)) {
            $this->render('errors/404.phtml', ['message' => 'ID inválido']);
            return;
        }

        $item = $this->model->find($id);
        if (!$item) {
            $this->render('errors/404.phtml', ['message' => 'Perfume no encontrado']);
            return;
        }

        $labs = $this->labModel->all();
        $this->render('admin/perfume_form.phtml', ['labs' => $labs, 'item' => $item]);
    }


    public function edit($id) {
        $this->checkAdmin();

        if (empty($id) || !is_numeric($id)) {
            $this->render('errors/404.phtml', ['message' => 'ID inválido']);
            return;
        }

        $id_laboratorio = $_POST['id_laboratorio'] ?? '';
        $precio = $_POST['precio'] ?? '';
        $codigo = trim($_POST['codigo'] ?? '');
        $duracion = trim($_POST['duracion'] ?? '');
        $aroma = trim($_POST['aroma'] ?? '');
        $sexo = trim($_POST['sexo'] ?? 0);

        // Validaciones
        if (
            empty($id_laboratorio) || !is_numeric($id_laboratorio) ||
            empty($precio) || !is_numeric($precio) ||
            empty($codigo) || empty($duracion) ||
            empty($aroma) || !is_numeric($sexo)
        ) {
            $error = 'Todos los campos son obligatorios y deben ser válidos.';
            $labs = $this->labModel->all();
            $item = $this->model->find($id);
            $this->render('admin/perfume_form.phtml', [
                'labs' => $labs,
                'item' => $item,
                'error' => $error
            ]);
            return;
        }

        $lab = $this->labModel->find($id_laboratorio);
        if (!$lab) {
            $error = 'El laboratorio seleccionado no existe.';
            $labs = $this->labModel->all();
            $item = $this->model->find($id);
            $this->render('admin/perfume_form.phtml', [
                'labs' => $labs,
                'item' => $item,
                'error' => $error
            ]);
            return;
        }

        $item = $this->model->find($id);
        if (!$item) {
            $this->render('errors/404.phtml', ['message' => 'Perfume no encontrado']);
            return;
        }

        $this->model->update($id, $id_laboratorio, $precio, $codigo, $duracion, $aroma, $sexo);
        header('Location: ' . BASE_URL . 'admin/perfumes');
    }
}
