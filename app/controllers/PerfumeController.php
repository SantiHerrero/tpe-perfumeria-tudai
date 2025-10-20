<?php
require_once __DIR__ . '/../models/PerfumeModel.php';
require_once __DIR__ . '/Controller.php';
class PerfumeController extends Controller {
    private $model;
    public function __construct(){ $this->model = new PerfumeModel(); }
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
        if (!isset($_SESSION['USER_ID'])) { header('Location: '.BASE_URL.'login'); exit; }
        $items = $this->model->all();
        $this->render('admin/perfumes_list.phtml', ['items'=>$items]);
    }
    public function adminCreateForm(){
        
    }
}
