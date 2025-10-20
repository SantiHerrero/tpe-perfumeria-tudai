<?php
require_once __DIR__ . '/../models/LaboratorioModel.php';
require_once __DIR__ . '/../models/PerfumeModel.php';
require_once __DIR__ . '/Controller.php';
class LaboratorioController extends Controller {
    private $model;
    public function __construct(){ $this->model = new LaboratorioModel(); }
    public function index(){
        $labs = $this->model->all();
        $this->render('laboratorios/list.phtml', ['labs'=>$labs]);
    }
    public function showPerfumes($id){
        if (!$id) { echo 'No ID'; return; }
        $perfModel = new PerfumeModel();
        $items = $perfModel->byLaboratorio($id);
        $lab = $this->model->find($id);
        $this->render('laboratorios/perfumes_by_lab.phtml', ['items'=>$items, 'lab'=>$lab]);
    }
    public function adminList(){
        session_start();
        if (!isset($_SESSION['USER_ID'])) { header('Location: '.BASE_URL.'login'); exit; }
        $labs = $this->model->all();
        $this->render('admin/laboratorios_list.phtml', ['labs'=>$labs]);
    }
}
