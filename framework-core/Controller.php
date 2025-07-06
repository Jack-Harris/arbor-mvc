<?php

class Controller {

    public function render(string $name, array $data = []) {
        extract($data);

        $viewFile = "../app/views/$name.php";
        $layoutFile = __DIR__ . "/views/layout.php";
        $contentView = $viewFile;

        include $layoutFile;
    }
}