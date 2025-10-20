<?php
class Controller {
    protected function render($viewPath, $data = []) {
        extract($data);
        require __DIR__ . '/../views/templates/header.phtml';
        require __DIR__ . '/../views/' . $viewPath;
        require __DIR__ . '/../views/templates/footer.phtml';
    }
}
