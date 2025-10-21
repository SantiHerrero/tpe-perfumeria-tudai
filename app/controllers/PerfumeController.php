<?php
require_once __DIR__ . '/../models/PerfumeModel.php';
require_once __DIR__ . '/../models/LaboratorioModel.php';
require_once __DIR__ . '/Controller.php';

class PerfumeController extends Controller {
    private $model;
    private $labModel;

    public function __construct(){
        $this->model = new PerfumeModel();
        $this->labModel = new LaboratorioModel();
    }

    public function index(){
        $items = $this->model->all();
        $this->render('perfumes/list.phtml', ['items'=>$items]);
    }

    public function show($id){
        if (!$id) { echo 'No ID'; return; }
        $item = $this->model->find($id);
        if (!$item) { echo 'Not found'; return; }
        $this->render('perfumes/detail.phtml', ['item'=>$item]);
    }

    public function adminList(){
        session_start();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: '.BASE_URL.'login');
            exit;
        }

        $items = $this->model->all();
        $laboratorios = $this->labModel->all();

        $this->render('admin/perfumes_list.phtml', [
            'items' => $items,
            'laboratorios' => $laboratorios
        ]);
    }

    public function adminCreateSubmit() {
        echo '<pre>';  // para que se vea mejor
    var_dump($_POST);
    echo '</pre>';
    exit; // corta la ejecución para ver solo esto
        session_start();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: '.BASE_URL.'login');
            exit;
        }

        $codigo = $_POST['codigo'] ?? null;
        $laboratorio_id = $_POST['laboratorio_id'] ?? null;
        $precio = $_POST['precio'] ?? null;

        if (!$codigo || !$laboratorio_id || !$precio) {
            echo "Faltan datos.";
            return;
        }

        $this->model->create($codigo, $laboratorio_id, $precio);

        header('Location: '.BASE_URL.'?action=admin/perfumes');
        exit;
    }
}